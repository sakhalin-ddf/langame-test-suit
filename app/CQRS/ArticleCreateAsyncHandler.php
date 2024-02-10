<?php

declare(strict_types=1);

namespace App\CQRS;

use App\Models\Article;
use Illuminate\Validation\Validator;

class ArticleCreateAsyncHandler
{
    public function __construct(
        private readonly ArticleStoreHandler $articleStoreHandler,
    ) {
        // do nothing
    }

    public function handle(ArticleCreateAsyncQuery $query): Article
    {
        $validator = new Validator(app()->get('translator'), $query->request->request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'image' => ['string', 'max:255'],
            'preview' => ['required', 'string'],
            'content' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'numeric'],
        ]);

        $validator->validate();

        $query = new ArticleStoreQuery(
            title: $query->request->request->get('title'),
            preview: $query->request->request->get('preview'),
            content: $query->request->request->get('content'),
            categories: \array_map(static fn($value) => (int)$value, $query->request->request->all('categories')),
            image: $query->request->request->get('image'),
        );

        return $this->articleStoreHandler->handle($query);
    }
}
