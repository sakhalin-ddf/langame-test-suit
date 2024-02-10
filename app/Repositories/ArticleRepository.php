<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ArticleRepository
{
    public function generateUniqueCode(string $title): string
    {
        $slugger = new AsciiSlugger();
        $base = $slugger->slug($title, '-', 'ru')->lower()->toString();

        while(\mb_strlen($base) > 120) {
            $base = \preg_replace('#-[^-]+$#', '', $base);
        }

        $suffix = '';

        while (true) {
            $code = $base . $suffix;
            $exists = DB::query()->from('articles')->where('code', '=', $code)->exists();

            if ($exists === false) {
                break;
            }

            $suffix = '-' . \bin2hex(\random_bytes(4));
        }

        return $code;
    }

    public function getList(?string $search = null, ?int $categoryId = null): iterable
    {
        $query = Article::query();

        if ($categoryId) {
            $query->join('article_category', 'articles.id', '=', 'article_category.article_id', 'inner');
            $query->where('article_category.category_id', '=', $categoryId);
        }

        if ($search) {
            $query->whereRaw('MATCH(title, content) AGAINST (? IN NATURAL LANGUAGE MODE)', [$search]);
            $query->orderByRaw('MATCH(title, content) AGAINST (? IN NATURAL LANGUAGE MODE) DESC', [$search]);
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        $query->limit(24);

        return $query->get();
    }

    public function getByCode(string $code): ?Article
    {
        $result = Article::query()->where('code', '=', $code)->get();

        return $result[0] ?? null;
    }
}
