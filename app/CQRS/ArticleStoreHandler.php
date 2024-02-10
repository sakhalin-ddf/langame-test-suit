<?php

declare(strict_types=1);

namespace App\CQRS;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Services\ArticleCodeGenerator;

class ArticleStoreHandler
{
    public function __construct(
        private readonly ArticleCodeGenerator $articleCodeGenerator,
        private readonly ArticleRepository $articleRepository,
    ) {
        // do nothing
    }

    public function handle(ArticleStoreQuery $query): Article
    {
        return $this->articleRepository->create(
            code: $this->articleCodeGenerator->generateByTitle($query->title),
            title: $query->title,
            preview: $query->preview,
            content: $query->content,
            categories: $query->categories,
            image: $query->image,
            originalUrl: $query->originalUrl,
            createdAt: $query->createdAt,
        );
    }
}
