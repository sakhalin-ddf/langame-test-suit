<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article;
use Carbon\Carbon;

class ArticleRepository
{
    public function create(
        string $code,
        string $title,
        string $preview,
        string $content,
        array $categories,
        ?string $image = null,
        ?string $originalUrl = null,
        ?\DateTimeInterface $createdAt = null,
    ): Article
    {
        $timezone = new \DateTimeZone('Europe/Moscow');
        $article = new Article();

        $article->code = $code;
        $article->title = $title;
        $article->preview = $preview;
        $article->content = $content;
        $article->image = $image;
        $article->original_url = $originalUrl;
        $article->created_at = $createdAt ? Carbon::parse($createdAt)->timezone($timezone) : new \DateTime('now', $timezone);
        $article->updated_at = $createdAt ? Carbon::parse($createdAt)->timezone($timezone) : new \DateTime('now', $timezone);

        $article->save();

        $article->categories()->attach($categories);

        return $article;
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

    public function existsByCode(string $code): bool
    {
        return Article::query()->where('code', '=', $code)->exists();
    }

    public function getByCode(string $code): ?Article
    {
        return Article::query()->where('code', '=', $code)->get()->first();
    }
}
