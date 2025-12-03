<?php declare(strict_types=1);

namespace Bugo\MoonShine\FontAwesome\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class UpdateIconsCommand extends Command
{
    protected $signature = 'moonshine:update-fa-icons';

    protected $description = 'Update FontAwesome icons';

    public function handle(): void
    {
        $sets = [
            base_path('node_modules/@fortawesome/fontawesome-free/svgs/regular') => [
                public_path('vendor/blade-fontawesome/regular'),
                base_path('vendor/bugo/blade-fontawesome/resources/svg/regular'),
            ],
            base_path('node_modules/@fortawesome/fontawesome-free/svgs/brands') => [
                public_path('vendor/blade-fontawesome/brands'),
                base_path('vendor/bugo/blade-fontawesome/resources/svg/brands'),
            ],
            base_path('node_modules/@fortawesome/fontawesome-free/svgs/solid') => [
                public_path('vendor/blade-fontawesome/solid'),
                base_path('vendor/bugo/blade-fontawesome/resources/svg/solid'),
            ],
        ];

        $fs = new Filesystem();

        foreach ($sets as $source => $destinations) {
            if (! $fs->exists($source)) {
                $this->error("Source directory not found: $source");
                continue;
            }

            array_walk($destinations, $fs->ensureDirectoryExists(...));

            foreach ($fs->allFiles($source) as $file) {
                if ($file->getExtension() !== 'svg') continue;

                $content = str_replace(
                    '<svg ',
                    '<svg fill="currentColor" ',
                    $file->getContents()
                );

                $target = $file->getFilename();

                array_walk($destinations, function ($dest) use ($fs, $target, $content) {
                    $fs->put($dest . '/' . $target, $content);
                });
            }
        }

        $this->call('icons:cache');

        $this->info('FontAwesome icons updated successfully!');
    }
}
