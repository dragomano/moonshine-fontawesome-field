<?php declare(strict_types=1);

use Bugo\MoonShine\FontAwesome\Enums\IconType;

test('enum has correct cases', function () {
    expect(IconType::cases())->toHaveCount(3)
        ->and(IconType::SOLID->value)->toBe('fas fa-')
        ->and(IconType::REGULAR->value)->toBe('far fa-')
        ->and(IconType::BRANDS->value)->toBe('fab fa-');
});

test('name method returns lowercase name', function () {
    expect(IconType::SOLID->name())->toBe('solid')
        ->and(IconType::REGULAR->name())->toBe('regular')
        ->and(IconType::BRANDS->name())->toBe('brands');
});

test('toString method returns concatenated values', function () {
    expect(IconType::toString())->toBe('fas fa-|far fa-|fab fa-');
});

test('can create from value', function () {
    expect(IconType::from('fas fa-'))->toBe(IconType::SOLID)
        ->and(IconType::from('far fa-'))->toBe(IconType::REGULAR)
        ->and(IconType::from('fab fa-'))->toBe(IconType::BRANDS);
});

test('throws exception for invalid value', function () {
    expect(fn () => IconType::from('invalid'))
        ->toThrow(ValueError::class);
});
