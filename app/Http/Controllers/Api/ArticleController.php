<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
    ) {
        // do nothing
    }

    public function search(Request $request): Response
    {
        return new JsonResponse([
            'data' => $this->articleRepository->getList($request->request->get('query')),
        ]);
    }
}
