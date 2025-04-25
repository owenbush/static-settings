<?php

declare(strict_types=1);

namespace StaticSettings\Tests;

use StaticSettings\BaseStaticSettingInterface;

/**
 * Test enum used in unit tests.
 */
enum TestEnvironment: string implements BaseStaticSettingInterface {
  case Development = 'development';
  case Staging = 'staging';
  case Production = 'production';
}
