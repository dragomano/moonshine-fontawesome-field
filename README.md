# MoonShine FontAwesome Field

![PHP](https://img.shields.io/badge/PHP-^8.2-blue.svg?style=flat)
[![Coverage Status](https://coveralls.io/repos/github/dragomano/moonshine-fontawesome-field/badge.svg?branch=main)](https://coveralls.io/github/dragomano/moonshine-fontawesome-field?branch=main)

Convenient Font Awesome icons selection field for [MoonShine](https://github.com/moonshine-software/moonshine)

### Support MoonShine versions

| MoonShine | This package |
| --------- | ------------ |
| 2.0+      | 0.x          |
| 3.0+      | 1.x          |

## Installation

```bash
composer require bugo/moonshine-fontawesome-field
```

## Usage

You can use `Icon` field in your resources:

```php
<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Bugo\MoonShine\Heroicons\Fields\Icon;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;

/**
 * @extends ModelResource<Custom>
 */
class CustomResource extends ModelResource
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Icon::make('Icon')
                ->searchable(),
        ];
    }
}
```

All use cases of [Blade Font Awesome](https://github.com/owenvoke/blade-fontawesome?tab=readme-ov-file#usage) are also available for you.

## Caching

When using icons in Blade templates, be sure to enable [Caching](https://github.com/blade-ui-kit/blade-icons?tab=readme-ov-file#caching).

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.
