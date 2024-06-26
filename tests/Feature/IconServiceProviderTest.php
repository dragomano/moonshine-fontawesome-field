<?php declare(strict_types=1);

use Bugo\MoonShine\FontAwesome\Providers\IconServiceProvider;
use Tests\TestCase;

uses(TestCase::class);

it('checks that the application instance is not null', function () {
    expect(app())->not->toBeNull();
});

it('checks that the IconServiceProvider class exists', function () {
    expect(class_exists(IconServiceProvider::class))->toBeTrue();
});

it('checks that IconServiceProvider is loaded', function () {
    expect(in_array(IconServiceProvider::class, array_keys(app()->getLoadedProviders()), true))->toBeTrue();
});

it('checks that the application returns an instance of IconServiceProvider', function () {
    expect(app()->getProvider(IconServiceProvider::class))->toBeInstanceOf(IconServiceProvider::class);
});
