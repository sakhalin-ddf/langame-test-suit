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
            'СНГ',
            'США',
            'Мир',
        ],

        'Спорт' => [
            'Футбол' => [
                'Чемпионат Мира',
                'Лига чемпионов',
            ],

            'Баскетбол' => [
                'Чемпионат Мира',
                'NBA',
                'Женский',
            ],

            'Шахматы' => [
                'Рапид',
                'Классика',
                'Онлайн',
            ],
        ],

        'Очень' => [
            'Ну очень' => [
                'Прям совсем' => [
                    'Супер большая' => [
                        'Вложенность категорий',
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
        $this->addCategories($this->categories);

        return self::SUCCESS;
    }

    private function addCategories(array $categories, ?int $parentId = null): void
    {
        foreach ($categories as $key => $value) {
            $name = \is_string($key) ? $key : $value;
            $children = \is_array($value) ? $value : [];

            $category = DB::table('categories')->where('name', '=', $name)->get()->first();

            if ($category === null) {
                $category = new Category();

                $category->parent_id = $parentId;
                $category->name = $name;

                $category->save();
            }

            $this->addCategories($children, $category->id);
        }
    }
}
