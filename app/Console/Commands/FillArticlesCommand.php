<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\CQRS\CreateArticleHandler;
use App\CQRS\CreateArticleQuery;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FillArticlesCommand extends Command
{
    protected $signature = 'app:fill-articles';
    protected $description = 'Fill articles from lenta.ru';

    public function __construct(
        private readonly CreateArticleHandler $createArticleHandler,
    )
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $categories = DB::table('categories')->select(['id'])->get();
        $categoryIds = \array_map(static fn($category) => $category->id, $categories->toArray());

        $rssUrlList = [
            'https://lenta.ru/rss',
            'https://habr.com/ru/rss/articles/?fl=ru&limit=50',
            'https://www.sport.ru/rssfeeds/news.rss',
            'https://overclockers.ru/rss/news.rss',
            'https://elementy.ru/rss/news',
        ];

        foreach ($rssUrlList as $rssUrl) {
            $xml = \simplexml_load_file($rssUrl, options: \LIBXML_NOCDATA);

            $items = $xml->xpath('//item');

            if (\is_array($items) === false) {
                continue;
            }

            \shuffle($items);

            foreach (\array_slice($items, 0, 50) as $item) {
                $exists = Article::query()->where(['original_url' => (string) $item->link])->exists();

                if ($exists) {
                    continue;
                }

                \shuffle($categoryIds);

                $preview = \trim((string) $item->description);

                // Разные RSS ленты содержат информацию о картинках в разных полях и разном формате
                // Строки ниже перечисляют возможные варианты хранения ссылки на изображение поста
                $image = null;

                // <item>...<enclosure url="http://path.to/image.jpeg"/>...</item>
                $image ??= isset($item->enclosure['url']) ? (string) $item->enclosure['url'] : null;

                // <item>...<image><url>http://path.to/image.jpeg</url></image>...</item>
                $image ??= isset($item->image->url) ? (string) $item->image->url : null;

                // <item>...<description><img src="http://path.to/image.jpeg"/> .....</description>...</item>
                if (\preg_match('#<img[^>]+src="([^"]+)"[^>]*>#', $preview, $matches)) {
                    $preview = \str_replace($matches[0], '', $preview);
                    $image ??= $matches[1];
                }

                $namespaces = $item->getNamespaces(true);

                // <item>...<media:content url="http://path.to/image.jpeg"/>...</item>
                if (isset($namespaces['media'])) {
                    $image ??= (string) $item->children($namespaces['media'])?->content->attributes()->url;
                }

                $preview = \preg_replace('#<a[^>]*>Читать далее[^<]*</a>#mui', '', $preview);
                $preview = \preg_replace('#<a[^>]*>Читать дальше[^<]*</a>#mui', '', $preview);
                $preview = \strip_tags($preview);
                $preview = \trim($preview);

                if (\mb_strlen($preview) < 20) {
                    continue;
                }

                $query = new CreateArticleQuery(
                    title: (string) $item->title,
                    preview: $preview,
                    content: "{$preview}\n\n{$preview}\n\n{$preview}\n\n{$preview}\n\n{$preview}",
                    categories: \array_slice($categoryIds, 0, \random_int(1, 5)),
                    image: $image,
                    originalUrl: (string) $item->link,
                    createdAt: Carbon::parse((string) $item->pubDate),
                );

                $this->createArticleHandler->handle($query);
            }
        }

        return self::SUCCESS;
    }
}
