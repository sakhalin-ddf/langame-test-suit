<?php

declare(strict_types=1);

namespace App\CQRS;

use Symfony\Component\HttpFoundation\Request;

class UploadFileStoreQuery
{
    public function __construct(
        public readonly Request $request,
    ) {
        // do nothing
    }
}
