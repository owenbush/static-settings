# Static Settings

[![Tests](https://github.com/owenbush/static-settings/actions/workflows/tests.yml/badge.svg)](https://github.com/owenbush/static-settings/actions/workflows/tests.yml)

A PHP library for managing static settings using a type-safe API with PHP 8.1+ enums.

## Requirements

* PHP 8.1 or higher

## Installation

You can install the package via composer:

```bash
composer require owenbush/static-settings
```


## Usage

### 1. Define Your Setting Enum

First, create an enum that implements `BaseStaticSettingInterface`:

```php
<?php

declare(strict_types=1);

namespace YOURNAMESPACE;

use StaticSettings\BaseStaticSettingInterface;

enum Environment: string implements BaseStaticSettingInterface {
  case Development = 'development';
  case Staging = 'staging';
  case Production = 'production';

  /**
  * {@inheritDoc}
  */
  public static function settingName(): string {
    return 'environment';
  }
}
```

### 2. Register Your Setting

Before you use your setting, you should register it. This prevents other code
from registering the same name and conflicting. This step is optional as when
you set a setting for the first time it will also register it.

```php
use StaticSettings\StaticSettings;

StaticSettings::registerSetting(Environment::class);
```

### 3. Set and Get Values

Now you can set and get values:

```php
// Set the environment
StaticSettings::set(Environment::class, Environment::Production);
// Get the current environment
$environment = StaticSettings::get(Environment::class);
if ($environment === Environment::Production) {
// Do production-specific things
}
```


### Error Handling

The library will throw `InvalidStaticSettingsException` in these cases:
- Attempting to get an unregistered setting
- Setting an invalid value for an enum
- Registering the same setting name with different classes


## Development

### Running Tests

#### Install Dependencies

```bash
composer install
```

#### Run test suite

```bash
vendor/bin/phpunit
```


### Contributing

1. Fork the repository
2. Create a feature branch
3. Write your changes
4. Write tests for your changes
5. Run the tests
6. Submit a pull request

Please make sure to update tests as appropriate and adhere to the existing coding style.

## License
Static Settings is open-source software licensed under the [GPL-2 License](https://github.com/e0ipso/twig-storybook/blob/main/LICENSE).
