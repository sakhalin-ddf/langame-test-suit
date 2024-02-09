<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\CQRS\CreateArticleHandler;
use App\CQRS\CreateArticleQuery;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

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
        return view('create-article', [
            'categoryTree' => $this->categoryRepository->tree(),
        ]);
    }

    public function createAndRedirect(Request $request)
    {
        $this->createArticleHandler->handle(CreateArticleQuery::createFromSyncRequest($request));

        return redirect('create-article-success');
    }

    public function renderCreateArticleSuccess()
    {
        return view('create-article-success');
    }
}
