<?php declare(strict_types=1);

namespace Bugo\MoonShine\FontAwesome\Enums;

enum IconType: string
{
    case SOLID = 'fas fa-';
    case REGULAR = 'far fa-';
    case BRANDS = 'fab fa-';

    public function name(): string
    {
        return strtolower($this->name);
    }

    public static function toString(): string
    {
        return implode('|', array_map(fn($item) => $item->value, self::cases()));
    }
}
