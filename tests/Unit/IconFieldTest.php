<?php declare(strict_types=1);

use Bugo\MoonShine\FontAwesome\Fields\Icon;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->field = Icon::make('Icon');

    $this->item = new class () extends Model {
        public string $icon = 'fas fa-user';
    };

    fillFromModel($this->field, $this->item);
});

describe('updated methods', function () {
    it('overrides option and optionProperties', function (): void {
        expect(
            $this->field->options(['1' => '2'])
                ->optionProperties(['1' => ['image' => 'https://www.svgrepo.com/show/397179/panda.svg']])
                ->getOptionProperties('1')
        )->toBe([]);
    });
});