<?php

namespace App\Http\Controllers\Api;

use App\CQRS\CreateArticleHandler;
use App\CQRS\CreateArticleQuery;
use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly CreateArticleHandler $createArticleHandler,
    ) {
        // do nothing
    }

    public function search(Request $request): Response
    {
        $list = $this->articleRepository->getList($request->request->get('query'));

        return new JsonResponse([
            'status' => 'ok',
            'data' => $list,
        ]);
    }

    public function save(Request $request): Response
    {
        $validator = new Validator(app()->get('translator'), $request->request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'image' => ['string', 'max:255'],
            'preview' => ['required', 'string'],
            'content' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'numeric'],
        ]);

        $validator->validate();

        $query = new CreateArticleQuery(
            title: $request->request->get('title'),
            preview: $request->request->get('preview'),
            content: $request->request->get('content'),
            categories: \array_map(static fn($value) => (int)$value, $request->request->all('categories')),
            image: $request->request->get('image'),
        );

        $article = $this->createArticleHandler->handle($query);

        return new JsonResponse([
            'status' => 'ok',
            'data' => $article,
        ]);
    }
}
