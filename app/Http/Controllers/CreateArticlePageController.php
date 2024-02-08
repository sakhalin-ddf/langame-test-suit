<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;

class CreateArticlePageController
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
    ) {
        // do nothing
    }

    public function render()
    {
        return view('create-article', [
            'categoryTree' => $this->categoryRepository->tree(),
        ]);
    }
}
