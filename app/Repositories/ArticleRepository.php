<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    public function getList(?string $search = null): iterable
    {
        $query = Article::query();

        if ($search) {
            $query->whereRaw('MATCH(title, content) AGAINST (? IN NATURAL LANGUAGE MODE)', [$search]);
        }

        $query->limit(18);
        $query->orderBy('id', 'DESC');

        return $query->get();
    }
}
