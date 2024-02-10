<?php

declare(strict_types=1);

namespace App\CQRS;

use App\Repositories\ArticleRepository;

class ArticleSearchHandler
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
    ) {
        // do nothing
    }

    public function handle(ArticleSearchQuery $query): iterable
    {
        return $this->articleRepository->getList($query->query, $query->categoryId);
    }
}
