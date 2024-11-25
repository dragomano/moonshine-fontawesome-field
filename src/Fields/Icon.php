<?php declare(strict_types=1);

namespace Bugo\MoonShine\FontAwesome\Fields;

use Bugo\MoonShine\FontAwesome\Enums\IconType;
use Closure;
use Illuminate\Support\Facades\Cache;
use MoonShine\AssetManager\Css;
use MoonShine\Support\DTOs\Select\Options;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Select;

class Icon extends Select
{
    public function __construct(Closure|string|null $label = null, ?string $column = null, ?Closure $formatted = null)
    {
        parent::__construct($label, $column, $formatted);

        $this->options = $this->getCustomOptions();
        $this->optionProperties = fn() => $this->getCustomOptionProperties();
    }

    public function getAssets(): array
    {
        return [
            Css::make('vendor/moonshine-fontawesome-field/css/app.css'),
        ];
    }

    public function options(Closure|array|Options $data): static
    {
        return $this;
    }

    public function optionProperties(Closure|array $data): static
    {
        return $this;
    }

    /**
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

    private function getStyleFromDirectory(string $name): string
    {
        return match ($name) {
            IconType::BRANDS->name() => IconType::BRANDS->value,
            IconType::REGULAR->name() => IconType::REGULAR->value,
            default => IconType::SOLID->value
        };
    }

    private function getDirectoryFromStyle(string $style): string
    {
        return match (true) {
            str_contains($style, IconType::BRANDS->value) => IconType::BRANDS->name(),
            str_contains($style, IconType::REGULAR->value) => IconType::REGULAR->name(),
            default => IconType::SOLID->name(),
        };
    }

    private function getShortName(string $name): string
    {
        return preg_replace('/' . IconType::toString() . '/', '', $name);
    }

    /**
     * @codeCoverageIgnore
     */
    private function getCustomOptions(): array
    {
        return Cache::rememberForever("fontawesome-field-options", function () {
            $items = array_map(function ($file) {
                $directory = basename(dirname($file));
                $filename = basename($file, '.svg');
                return $this->getStyleFromDirectory($directory) . $filename;
            }, glob(public_path("vendor/blade-fontawesome/*/*.svg"), GLOB_BRACE));

            return array_combine($items, $items);
        });
    }

    /**
     * @codeCoverageIgnore
     */
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
