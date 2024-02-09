<?php

declare(strict_types=1);

namespace App\CQRS;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateArticleQuery
{
    public function __construct(
        public readonly string $title,
        public readonly string $preview,
        public readonly string $content,
        public readonly array $categories,
        public readonly ?string $image = null,
        public readonly ?string $original_url = null,
    ) {
        // do nothing
    }

    public static function createFromSyncRequest(Request $request): self
    {
        $validator = new Validator(app()->get('translator'), $request->request->all(), [
            'title' => ['required', 'max:255'],
            'preview' => ['required'],
            'content' => ['required'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'numeric'],
        ]);

        $validator->validate();

        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        if ($file !== null) {
            $path = \sprintf(
                '/public/upload/%s/%s/%s/%s.%s',
                \date('Y'),
                \date('m'),
                \date('d'),
                Uuid::uuid4()->toString(),
                $file->getExtension() ?: $file->getClientOriginalExtension(),
            );

            \Illuminate\Http\UploadedFile::createFromBase($file)->storePubliclyAs($path);

            $image = \str_replace('/public/', '/storage/', $path);
        } else {
            $image = null;
        }

        return new CreateArticleQuery(
            title: $request->request->get('title'),
            preview: $request->request->get('preview'),
            content: $request->request->get('content'),
            categories: \array_map(static fn ($value) => (int) $value, $request->request->all('categories')),
            image: $image,
        );
    }

    public static function createFromAsyncRequest(Request $request): self
    {
        return new CreateArticleQuery();
    }
}
