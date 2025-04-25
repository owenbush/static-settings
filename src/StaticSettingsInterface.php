<?php

declare(strict_types=1);

namespace StaticSettings;

/**
 * Interface for defining methods and properties for the StaticSettings class.
 */
interface StaticSettingsInterface {

  /**
   * Register a class to be used with static settings.
   *
   * @param string $class
   *   The class used to validate the setting.
   */
  public static function registerSetting(string $class): void;

  /**
   * Set a static setting value.
   *
   * @param string $class
   *   The class of the setting.
   * @param int|string $setting_value
   *   The value of the setting.
   */
  public static function set(string $class, mixed $setting_value): void;

  /**
   * Set multiple static setting values at once.
   *
   * @param array $settings
   *   Array of settings where key is a class namespace and value is the value.
   */
  public static function setMultiple(array $settings): void;

  /**
   * Get a static setting value.
   *
   * @param string $class
   *   The class of the setting.
   *
   * @return BaseStaticSettingInterface
   *   The setting value.
   */
  public static function get(string $class): ?BaseStaticSettingInterface;

}
