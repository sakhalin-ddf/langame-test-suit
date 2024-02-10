<?php

namespace App\Http\Controllers\Api;

use App\CQRS\ArticleCreateAsyncHandler;
use App\CQRS\ArticleCreateAsyncQuery;
use App\CQRS\ArticleSearchHandler;
use App\CQRS\ArticleSearchQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleCreateAsyncHandler $articleCreateAsyncHandler,
        private readonly ArticleSearchHandler $articleSearchHandler,
    ) {
        // do nothing
    }

    public function search(Request $request): Response
    {
        $query = $request->request->get('query');
        $categoryId = $request->request->get('category_id');

        $list = $this->articleSearchHandler->handle(new ArticleSearchQuery(
            query: $query,
            categoryId: $categoryId ? (int)$categoryId : null,
        ));

        return new JsonResponse([
            'status' => 'ok',
            'data' => $list,
        ]);
    }

    public function save(Request $request): Response
    {
        $article = $this->articleCreateAsyncHandler->handle(new ArticleCreateAsyncQuery($request));

        return new JsonResponse([
            'status' => 'ok',
            'data' => $article,
        ]);
    }
}
