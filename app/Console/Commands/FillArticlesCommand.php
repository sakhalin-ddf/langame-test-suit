<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FillArticlesCommand extends Command
{
    protected $signature = 'app:fill-articles';
    protected $description = 'Fill articles from lenta.ru';

    public function handle(): int
    {
        $categories = DB::table('categories')->select(['id'])->get();
        $categoryIds = \array_map(static fn($category) => $category->id, $categories->toArray());

        $url = 'https://lenta.ru/rss';
        $xml = \simplexml_load_file($url, options: \LIBXML_NOCDATA);

        $items = $xml->xpath('//item');

        foreach ($items as $item) {
            $exists = Article::query()->where(['original_url' => (string) $item->link])->get();

            if ($exists->count() > 0) {
                continue;
            }

            $article = new Article();

            $article->original_url = (string)$item->link;
            $article->image = isset($item->enclosure['url']) ? $item->enclosure['url']->__toString() : null;
            $article->title = (string)$item->title;
            $article->preview = \trim((string)$item->description);
            $article->content = "{$article->preview}\n\n{$article->preview}\n\n{$article->preview}";

            $article->save();

            \shuffle($categoryIds);

            $article->categories()->attach(
                \array_slice(
                    $categoryIds,
                    0,
                    \random_int(1, 5),
                ),
            );
        }

        return self::SUCCESS;
    }
}
