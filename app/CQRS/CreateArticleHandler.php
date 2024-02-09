<?php

declare(strict_types=1);

namespace App\CQRS;

use App\Models\Article;

class CreateArticleHandler
{
    public function handle(CreateArticleQuery $query): Article
    {
        $article = new Article();

        $article->title = $query->title;
        $article->preview = $query->preview;
        $article->content = $query->content;
        $article->image = $query->image;

        $article->save();

        $article->categories()->attach($query->categories);

        return $article;
    }
}
