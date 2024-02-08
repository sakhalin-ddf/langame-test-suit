<?php

declare(strict_types=1);

namespace App\Helpers;

class Html
{
    public static function categoryTreeOptions(array $tree, int $depth = 0): string
    {
        $options = '';

        foreach ($tree as $item) {
            $prefix = $depth > 0 ? \str_pad('-', $depth, '-', \STR_PAD_RIGHT) . ' ' : '';
            $name = \htmlentities($item['name']);
            $options .= "<option value='{$item['id']}'>{$prefix}{$name}</option>";
            $options .= "\n";

            if (!empty($item['children'])) {
                $options .= self::categoryTreeOptions($item['children'], $depth + 1);
                $options .= "\n";
            }
        }

        return \trim($options);
    }
}
