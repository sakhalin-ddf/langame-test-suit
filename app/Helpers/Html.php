<?php

declare(strict_types=1);

namespace App\Helpers;

class Html
{
    public static function renderCategoryTreeOptions(array $tree, int $depth = 0): string
    {
        $options = '';

        foreach ($tree as $item) {
            $prefix = $depth > 0 ? \str_pad('-', $depth, '-', \STR_PAD_RIGHT) . ' ' : '';
            $name = \htmlentities($item['name']);
            $options .= "<option value='{$item['id']}'>{$prefix}{$name}</option>";
            $options .= "\n";

            if (!empty($item['children'])) {
                $options .= self::renderCategoryTreeOptions($item['children'], $depth + 1);
                $options .= "\n";
            }
        }

        return \trim($options);
    }

    public static function renderCategoryTreeMenu(array $tree, int $depth = 0): string
    {
        $menu = '<ul>';

        foreach ($tree as $item) {
            $name = \htmlentities($item['name']);
            $menu .= "<li>";
            $menu .= "<a href=\"/category/{$item['id']}\">{$name}</a>";

            if (!empty($item['children'])) {
                $menu .= self::renderCategoryTreeMenu($item['children'], $depth + 1);
            }

            $menu .= "</li>";
        }

        $menu .= '</ul>';

        return \trim($menu);
    }
}
