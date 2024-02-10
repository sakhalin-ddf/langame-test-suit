<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CQRS\CreateArticleHandler;
use App\CQRS\CreateArticleQuery;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Services\Uploader;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SiteController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly CreateArticleHandler $createArticleHandler,
        private readonly Uploader $uploader,
    ) {
        // do nothing
    }

    public function renderArticleSearch(Request $request)
    {
        $query = $request->query->get('query');

        return view('article-search', [
            'query' => $query,
            'articles' => $this->articleRepository->getList($query),
        ]);
    }

    public function renderArticleCreate()
    {
        return view('article-create', [
            'categoryTree' => $this->categoryRepository->tree(),
        ]);
    }

    public function renderArticleView(string $code)
    {
        $article = $this->articleRepository->getByCode($code);

        return view('article-view', [
            'article' => $article,
        ]);
    }

    public function renderCategoryList()
    {
        return view('category-list', [
            'categoryTree' => $this->categoryRepository->tree(),
        ]);
    }

    public function renderCategoryView(Request $request, int $categoryId)
    {
        $query = $request->query->get('query');

        return view('article-search', [
            'query' => $query,
            'category' => $this->categoryRepository->find($categoryId),
            'articles' => $this->articleRepository->getList($query, $categoryId),
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
        $image = $file ? $this->uploader->store($file) : null;

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

    public function renderArticleCreateSuccess()
    {
        return view('article-create-success');
    }
}
