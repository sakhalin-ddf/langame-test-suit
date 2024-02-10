<?php

declare(strict_types=1);

namespace App\CQRS;

use App\Services\Uploader;

class UploadFileStoreHandler
{
    public function __construct(
        private readonly Uploader $uploader,
    ) {
        // do nothing
    }

    public function handle(UploadFileStoreQuery $query): string
    {
        $file = $query->request->files->get('file');

        if ($file === null) {
            throw new \RuntimeException('Uploaded file expected.');
        }

        return $this->uploader->store($file);
    }
}
