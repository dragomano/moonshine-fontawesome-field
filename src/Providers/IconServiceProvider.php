<?php declare(strict_types=1);

namespace Bugo\MoonShine\FontAwesome\Providers;

use Bugo\MoonShine\FontAwesome\Commands\UpdateIconsCommand;
use Illuminate\Support\ServiceProvider;

class IconServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $paths = [
            [
                'from' => __DIR__ . '/../../public',
                'to' => public_path('vendor/moonshine-fontawesome-field'),
                'groups' => ['moonshine-fontawesome-field', 'laravel-assets'],
            ],
            [
                'from' => base_path() . '/vendor/bugo/blade-fontawesome/resources/svg',
                'to' => public_path('vendor/blade-fontawesome'),
                'groups' => ['blade-fontawesome', 'laravel-assets'],
            ],
        ];

        if ($this->app->runningInConsole()) {
            foreach ($paths as $path) {
                $this->publishes([$path['from'] => $path['to']], $path['groups']);
            }

            $this->commands([
                UpdateIconsCommand::class,
            ]);
        }
    }
}
