<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use MoonShine\UI\Fields\Field;

function fillFromModel(Field $field, Model $model): void
{
    $field->fillData($model);
}

function publishFontAwesomeIcons(string ...$names): void
{
    $directory = public_path('vendor/blade-fontawesome/solid');

    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    foreach ($names as $name) {
        file_put_contents(
            $directory . '/' . $name . '.svg',
            '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 0h512v512H0z"/></svg>'
        );
    }

    Cache::forget('fontawesome_field_options');
    Cache::forget('fontawesome_field_option_properties');
}

function removePublishedFontAwesomeIcons(): void
{
    $directory = public_path('vendor/blade-fontawesome/solid');

    if (! is_dir($directory)) {
        return;
    }

    foreach (glob($directory . '/*.svg') ?: [] as $file) {
        unlink($file);
    }
}
