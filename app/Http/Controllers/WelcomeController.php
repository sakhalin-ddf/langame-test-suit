<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class WelcomeController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
    ) {
        // do nothing
    }

    public function welcome(Request $request)
    {
        $query = $request->query->get('query');

        return view('welcome', [
            'query' => $query,
            'articles' => $this->articleRepository->getList($query),
        ]);
    }
}
