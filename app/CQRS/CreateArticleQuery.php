<?php

declare(strict_types=1);

namespace App\CQRS;

class CreateArticleQuery
{
    public function __construct(
        public readonly string $title,
        public readonly string $preview,
        public readonly string $content,
        public readonly array $categories,
        public readonly ?string $image = null,
    ) {
        // do nothing
    }
}
