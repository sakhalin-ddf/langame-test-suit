<?php

declare(strict_types=1);

namespace App\CQRS;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleCreateSyncQuery
{
    public function __construct(
        public readonly Request $request,
    ) {
        // do nothing
    }
}
