<?php

declare(strict_types=1);

namespace App\CQRS;

use App\Models\Article;
use App\Services\Uploader;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArticleCreateSyncHandler
{
    public function __construct(
        private readonly Uploader $uploader,
        private readonly ArticleStoreHandler $articleStoreHandler,
    ) {
        // do nothing
    }

    public function handle(ArticleCreateSyncQuery $query): Article
    {
        $validator = new Validator(app()->get('translator'), $query->request->request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'preview' => ['required', 'string'],
            'content' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'numeric'],
        ]);

        $validator->validate();

        /** @var UploadedFile $file */
        $file = $query->request->files->get('file');

        $query = new ArticleStoreQuery(
            title: $query->request->request->get('title'),
            preview: $query->request->request->get('preview'),
            content: $query->request->request->get('content'),
            categories: \array_map(static fn($value) => (int) $value, $query->request->request->all('categories')),
            image: $file ? $this->uploader->store($file) : null,
        );

        return $this->articleStoreHandler->handle($query);
    }
}
