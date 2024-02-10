<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile as LaravelUploadedFile;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

class Uploader
{
    public function store(SymfonyUploadedFile $uploadedFile): string
    {
        $uploadedFile = LaravelUploadedFile::createFromBase($uploadedFile);

        $path = \sprintf(
            '/public/upload/%s/%s/%s/%s.%s',
            \date('Y'),
            \date('m'),
            \date('d'),
            Uuid::uuid4()->toString(),
            $uploadedFile->getExtension() ?: $uploadedFile->getClientOriginalExtension(),
        );

        $uploadedFile->storePubliclyAs($path);

        return \str_replace('/public/', '/storage/', $path);
    }
}
