<?php

declare(strict_types=1);

namespace App\CQRS;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Carbon\Carbon;

class CreateArticleHandler
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
    ) {
        // do nothing
    }

    public function handle(CreateArticleQuery $query): Article
    {
        $timezone = new \DateTimeZone('Europe/Moscow');
        $article = new Article();

        $article->code = $this->articleRepository->generateUniqueCode($query->title);
        $article->title = $query->title;
        $article->preview = $query->preview;
        $article->content = $query->content;
        $article->image = $query->image;
        $article->original_url = $query->originalUrl;
        $article->created_at = $query->createdAt ? Carbon::parse($query->createdAt)->timezone($timezone) : new \DateTime('now', $timezone);
        $article->updated_at = $query->createdAt ? Carbon::parse($query->createdAt)->timezone($timezone) : new \DateTime('now', $timezone);

        $article->save();

        $article->categories()->attach($query->categories);

        return $article;
    }
}
