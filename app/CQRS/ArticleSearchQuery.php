<?php

declare(strict_types=1);

namespace App\CQRS;

use Symfony\Component\HttpFoundation\Request;

class ArticleSearchQuery
{
    public function __construct(
        public readonly ?string $query = null,
        public readonly ?int $categoryId = null,
    ) {
        // do nothing
    }
}
