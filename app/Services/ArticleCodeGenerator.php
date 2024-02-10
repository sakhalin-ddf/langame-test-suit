<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ArticleRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ArticleCodeGenerator
{
    public function __construct(
        private readonly ArticleRepository $articleRepository
    ) {
        // do nothing
    }

    public function generateByTitle(string $title): string
    {
        $slugger = new AsciiSlugger();
        $base = $slugger->slug($title, '-', 'ru')->lower()->toString();

        while (\mb_strlen($base) > 120) {
            $base = \preg_replace('#-[^-]+$#', '', $base);
        }

        $suffix = '';

        while (true) {
            $code = $base . $suffix;

            if ($this->articleRepository->existsByCode($code) === false) {
                break;
            }

            $suffix = '-' . \bin2hex(\random_bytes(4));
        }

        return $code;
    }
}
