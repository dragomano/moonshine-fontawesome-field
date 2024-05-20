<?php declare(strict_types=1);

/**
 * Icon.php
 *
 * @package bugo/moonshine-fontawesome-field
 * @link https://github.com/dragomano/moonshine-fontawesome-field
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2024 Bugo
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @version 0.1
 */

namespace Bugo\MoonShine\FontAwesome\Fields;

use Closure;
use Illuminate\Support\Facades\Cache;
use MoonShine\Fields\Select;
use MoonShine\Fields\Preview;

class Icon extends Select
{
    protected array $assets = [
        'vendor/moonshine-fontawesome-field/css/app.css',
    ];

    public function __construct(Closure|string|null $label = null, ?string $column = null, ?Closure $formatted = null)
    {
        parent::__construct($label, $column, $formatted);

        $this->options = $this->getCustomOptions();
        $this->optionProperties = fn() => $this->getCustomOptionProperties();
    }

    public function options(array|Closure $data): static
    {
        return $this;
    }

    public function optionProperties(array|Closure $data): static
    {
        return $this;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    protected function resolvePreview(): string
    {
        $value = parent::resolvePreview();

        if ($value === '') {
            return '';
        }

        $icons = array_filter(explode(',', $value));

        $result = array_map(
            fn($icon) => svg(str_replace(' fa', '', $icon), 'h-6 w-6')->toHtml(),
            $icons
        );

        return (string) Preview::make(formatted: static fn() => implode('', $result))
            ->setAttribute('class', 'flex items-center');
    }

    /**
     * @codeCoverageIgnore
     */
    private function getStyleFromDirectory(string $name): string
    {
        return match ($name) {
            'brands'  => 'fab fa-',
            'regular' => 'far fa-',
            default   => 'fas fa-'
        };
    }

    /**
     * @codeCoverageIgnore
     */
    private function getDirectoryFromStyle(string $style): string
    {
        return match (true) {
            str_contains($style, 'fab fa-') => 'brands',
            str_contains($style, 'far fa-') => 'regular',
            default => 'solid',
        };
    }

    /**
     * @codeCoverageIgnore
     */
    private function getShortName(string $name): string
    {
        return preg_replace('/fas fa-|fab fa-|far fa-/', '', $name);
    }

    /**
     * @codeCoverageIgnore
     */
    private function getCustomOptions(): array
    {
        return Cache::rememberForever("fontawesome-field-options", function () {
            $items = array_map(function($file) {
                $directory = basename(dirname($file));
                $filename = basename($file, '.svg');
                return $this->getStyleFromDirectory($directory) . $filename;
            }, glob(public_path("vendor/blade-fontawesome/*/*.svg"), GLOB_BRACE));

            return array_combine($items, $items);
        });
    }

    private function getCustomOptionProperties(): array
    {
        return Cache::rememberForever("fontawesome-field-option-properties", function () {
            $link = asset("vendor/blade-fontawesome/%s/%s.svg");

            return array_map(
                fn($item) => [
                    'image' => sprintf($link, $this->getDirectoryFromStyle($item), $this->getShortName($item))
                ],
                $this->getCustomOptions()
            );
        });
    }
}
