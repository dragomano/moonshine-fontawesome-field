<?php declare(strict_types=1);

use Bugo\MoonShine\FontAwesome\Enums\IconType;
use Bugo\MoonShine\FontAwesome\Fields\Icon;
use Illuminate\Database\Eloquent\Model;
use MoonShine\AssetManager\Css;
use MoonShine\Support\DTOs\Select\Option;
use MoonShine\Support\DTOs\Select\OptionProperty;
use MoonShine\Support\DTOs\Select\Options;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->field = Icon::make('Icon');

    $this->item = new class () extends Model {
        public string $icon = 'fas fa-user';
    };

    fillFromModel($this->field, $this->item);
});

test('icon field can be instantiated', function () {
    expect($this->field)
        ->toBeInstanceOf(Icon::class)
        ->and($this->field->getLabel())->toBe('Icon');
});

test('assets are correctly defined', function () {
    expect($this->field->getAssets())
        ->toBeArray()
        ->toHaveCount(1)
        ->and($this->field->getAssets()[0])
        ->toBeInstanceOf(Css::class)
        ->and($this->field->getAssets()[0]->getLink())
        ->toBe('vendor/moonshine-fontawesome-field/css/app.css');
});

describe('override methods', function () {
	it('overrides option', function (): void {
		expect(
			$this->field->options(new Options([
				new Option(
					'panda',
					'panda',
					properties: new OptionProperty('https://www.svgrepo.com/show/397179/panda.svg')
				)
			]))
				->getValues()
				->toArray()
		)->toBe([]);
	});

	it('overrides optionProperties', function (): void {
		expect(
			$this->field->optionProperties(fn() => [
				'fas fa-panda' => ['image' => 'https://www.svgrepo.com/show/397179/panda.svg']
			])
				->getValues()
				->toArray()
		)->toBe([]);
	});
});

test('resolvePreview returns empty string for empty value', function () {
    expect($this->field->preview())->toBe('');
});

test('getStyleFromDirectory returns correct style', function () {
    $method = new ReflectionMethod(Icon::class, 'getStyleFromDirectory');
	$method->setAccessible(true);

    expect($method->invoke($this->field, IconType::BRANDS->name()))->toBe(IconType::BRANDS->value)
        ->and($method->invoke($this->field, IconType::REGULAR->name()))->toBe(IconType::REGULAR->value)
        ->and($method->invoke($this->field, IconType::SOLID->name()))->toBe(IconType::SOLID->value);
});

test('getDirectoryFromStyle returns correct directory', function () {
    $method = new ReflectionMethod(Icon::class, 'getDirectoryFromStyle');
    $method->setAccessible(true);

    expect($method->invoke($this->field, 'fab fa-'))->toBe(IconType::BRANDS->name())
        ->and($method->invoke($this->field, 'far fa-'))->toBe(IconType::REGULAR->name())
        ->and($method->invoke($this->field, 'fas fa-'))->toBe(IconType::SOLID->name());
});

test('getShortName removes style prefix', function () {
    $method = new ReflectionMethod(Icon::class, 'getShortName');
    $method->setAccessible(true);

    expect($method->invoke($this->field, 'fas fa-user'))->toBe('user');
});
