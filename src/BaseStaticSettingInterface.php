<?php

declare(strict_types=1);

namespace StaticSettings;

/**
 * Interface for static settings.
 */
interface BaseStaticSettingInterface {

  /**
   * The name of the setting used for registration and retrieval.
   *
   * @return string
   *   The setting name.
   */
  public static function settingName(): string;

}
