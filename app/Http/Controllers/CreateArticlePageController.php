<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CQRS\CreateArticleHandler;
use App\CQRS\CreateArticleQuery;
use App\Helpers\Uploader;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateArticlePageController
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly CreateArticleHandler $createArticleHandler,
    ) {
        // do nothing
    }

    public function renderCreateArticle()
    {
        return view('article-create', [
            'categoryTree' => $this->categoryRepository->tree(),
        ]);
    }

    public function createAndRedirect(Request $request)
    {
        $validator = new Validator(app()->get('translator'), $request->request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'preview' => ['required', 'string'],
            'content' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'numeric'],
        ]);

        $validator->validate();

        /** @var UploadedFile $file */
        $file = $request->files->get('file');
        $image = $file ? Uploader::upload($file) : null;

        $query = new CreateArticleQuery(
            title: $request->request->get('title'),
            preview: $request->request->get('preview'),
            content: $request->request->get('content'),
            categories: \array_map(static fn($value) => (int)$value, $request->request->all('categories')),
            image: $image,
        );

        $this->createArticleHandler->handle($query);

        return redirect('article-create-success');
    }

    public function renderCreateArticleSuccess()
    {
        return view('article-create-success');
    }
}
