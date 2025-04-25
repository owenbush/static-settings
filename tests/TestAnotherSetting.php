<?php

declare(strict_types=1);

namespace StaticSettings\Tests;

use StaticSettings\BaseStaticSettingInterface;

/**
 * Another test enum used in unit tests.
 */
enum TestAnotherSetting: string implements BaseStaticSettingInterface {
  case Value1 = 'value1';
  case Value2 = 'value2';
}
