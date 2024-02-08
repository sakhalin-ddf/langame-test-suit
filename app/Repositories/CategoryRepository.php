<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function tree(): array
    {
        $list = [];
        $tree = [];
        $categories = Category::query()->get()->all();

        foreach ($categories as $category) {
            $list[$category->id] = [
                'id' => $category->id,
                'name' => $category->name,
                'children' => [],
            ];
        }

        foreach ($categories as $category) {
            if ($category->parent_id) {
                $list[$category->parent_id]['children'][] = &$list[$category->id];
            } else {
                $tree[] = &$list[$category->id];
            }
        }

        return $tree;
    }
}
