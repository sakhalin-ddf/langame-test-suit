<?php

declare(strict_types=1);

namespace App\CQRS;

class ArticleStoreQuery
{
    public function __construct(
        public readonly string $title,
        public readonly string $preview,
        public readonly string $content,
        public readonly array $categories,
        public readonly ?string $image = null,
        public readonly ?string $originalUrl = null,
        public readonly ?\DateTimeInterface $createdAt = null,
    ) {
        // do nothing
    }
}
