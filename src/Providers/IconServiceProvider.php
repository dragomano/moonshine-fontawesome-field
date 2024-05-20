<?php declare(strict_types=1);

/**
 * IconServiceProvider.php
 *
 * @package bugo/moonshine-fontawesome-field
 * @link https://github.com/dragomano/moonshine-fontawesome-field
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2024 Bugo
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @version 0.1
 */

namespace Bugo\MoonShine\FontAwesome\Providers;

use Illuminate\Support\ServiceProvider;

class IconServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../public' => public_path('vendor/moonshine-fontawesome-field'),
            ], ['moonshine-fontawesome-field', 'laravel-assets']);

            $this->publishes([
                base_path() . '/vendor/owenvoke/blade-fontawesome/resources/svg' => public_path('vendor/blade-fontawesome'),
            ], ['blade-fontawesome', 'laravel-assets']);
        }
    }
}
