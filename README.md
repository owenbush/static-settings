# Static Settings

[![Tests](https://github.com/owenbush/static-settings/actions/workflows/tests.yml/badge.svg)](https://github.com/owenbush/static-settings/actions/workflows/tests.yml)

A PHP library for managing static settings using PHP enums. This library provides a type-safe way to manage global settings in your PHP application using PHP 8.1+ enums.

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
  case DEVELOPMENT = 'development';
  case STAGING = 'staging';
  case PRODUCTION = 'production';

  /**
  * {@inheritDoc}
  */
  public static function settingName(): string {
    return 'environment';
  }
}
```

### 2. Register Your Setting

Before you can use a setting, you need to register it:

```php
use StaticSettings\StaticSettings;

StaticSettings::registerValue(Environment::class);
```

### 3. Set and Get Values

Now you can set and get values:

```php
// Set the environment
StaticSettings::set(Environment::class, Environment::PRODUCTION);
// Get the current environment
$environment = StaticSettings::get(Environment::class);
if ($environment === Environment::PRODUCTION) {
// Do production-specific things
}
```


### Error Handling

The library will throw `InvalidStaticSettingsException` in these cases:
- Attempting to get/set an unregistered setting
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
