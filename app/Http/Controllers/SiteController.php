<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CQRS\ArticleCreateSyncHandler;
use App\CQRS\ArticleCreateSyncQuery;
use App\CQRS\ArticleSearchHandler;
use App\CQRS\ArticleSearchQuery;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class SiteController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly ArticleSearchHandler $articleSearchHandler,
        private readonly ArticleCreateSyncHandler $articleCreateSyncHandler,
    ) {
        // do nothing
    }

    public function renderArticleSearch(Request $request)
    {
        $query = $request->query->get('query');
        $articles = $this->articleSearchHandler->handle(new ArticleSearchQuery(query: $query));

        return view('article-search', [
            'query' => $query,
            'articles' => $articles,
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
        $category = $this->categoryRepository->find($categoryId);
        $articles = $this->articleSearchHandler->handle(new ArticleSearchQuery(query: $query, categoryId: $categoryId));

        return view('article-search', [
            'query' => $query,
            'category' => $category,
            'articles' => $articles,
        ]);
    }

    public function createAndRedirect(Request $request)
    {
        $this->articleCreateSyncHandler->handle(new ArticleCreateSyncQuery($request));

        return redirect('article-create-success');
    }

    public function renderArticleCreateSuccess()
    {
        return view('article-create-success');
    }
}
