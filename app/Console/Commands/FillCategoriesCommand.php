<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FillCategoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create category structure';

    private array $categories = [
        'Политика' => [
            'Россия',
            'Мир',
            'США',
            'СНГ' => [
                'Казахстан',
                'Узбекистан',
                'Таджикистан',
                'Армения',
            ],
            'Ближний восток' => [
                'Турция',
                'Иран',
                'Ирак',
                'ОАЭ',
            ],
        ],

        'Спорт' => [
            'Футбол' => [
                'Чемпионат Мира Футбол',
                'Лига чемпионов',
                'FIFA',
                'Пляжный футбол',
            ],

            'Баскетбол' => [
                'Чемпионат Мира Баскетбол',
                'NBA',
                'Баскетбол Россия',
                'Баскетбол Женский',
            ],

            'Шахматы' => [
                'Шахматы Рапид',
                'Шахматы Классика',
                'Шахматы онлайн',
                'Шахматы молодежка' => [
                    'Шахматы, школьники 1-3 классов',
                    'Шахматы, школьники 5-9 классов',
                    'Шахматы, школьники 10-11 классов',
                    'Шахматы, студенты' => [
                        'Шахматы, студенты МГУ',
                        'Шахматы, студенты СПБГУ',
                        'Шахматы, студенты НГУ',
                    ],
                ],
            ],
        ],
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $exists = DB::table('categories')->exists();

        if ($exists === false) {
            $this->addCategories($this->categories);
        }

        return self::SUCCESS;
    }

    private function addCategories(array $categories, ?int $parentId = null): void
    {
        foreach ($categories as $key => $value) {
            $name = \is_string($key) ? $key : $value;
            $children = \is_array($value) ? $value : [];

            $category = new Category();

            $category->parent_id = $parentId;
            $category->name = $name;

            $category->save();

            $this->addCategories($children, $category->id);
        }
    }
}
