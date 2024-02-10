<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\CQRS\UploadFileStoreHandler;
use App\CQRS\UploadFileStoreQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadController
{
    public function __construct(
        private readonly UploadFileStoreHandler $uploadFileStoreHandler,
    ) {
        // do nothing
    }

    public function save(Request $request): Response
    {
        try {
            $image = $this->uploadFileStoreHandler->handle(new UploadFileStoreQuery($request));

            return new JsonResponse([
                'status' => 'ok',
                'data' => $image,
            ]);
        } catch (\Throwable $exception) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'error' => $exception->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }
}
