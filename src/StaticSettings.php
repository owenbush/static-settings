<?php

declare(strict_types=1);

namespace StaticSettings;

/**
 * Class for defining, storing and retrieving static settings.
 */
final class StaticSettings implements StaticSettingsInterface {

  /**
   * Array of registered values.
   *
   * @var arraystringclassstring
   */
  private static array $registeredValues = [];

  /**
   * Array of values.
   *
   * @var arraystringmixed
   */
  private static array $values = [];

  /**
   * {@inheritdoc}
   */
  public static function registerSetting(string $class): void {
    if (!is_subclass_of($class, BaseStaticSettingInterface::class)) {
      throw new \Exception('Class must implement BaseStaticSettingInterface: ' . $class);
    }
    $setting_name = $class::settingName();
    if (
      isset(self::$registeredValues[$setting_name])
      && self::$registeredValues[$setting_name] !== $class
    ) {
      throw new \Exception('Value already registered with a different class.');
    }
    self::$registeredValues[$setting_name] = $class;
  }

  /**
   * Register a class to be used with static settings.
   *
   * @param string $class
   *   The class used to validate the setting.
   *
   * @deprecated in 1.1.0 and is removed from 2.0.0. Use ::registerSetting instead.
   * @see https://github.com/owenbush/static-settings/issues/1
   */
  public static function registerValue(string $class): void {
    @trigger_error(sprintf('The method %s is deprecated in 1.1.0 and is removed from 2.0.0. Use ::registerSetting instead. See https://github.com/owenbush/static-settings/issues/1', __METHOD__), E_USER_DEPRECATED);
    self::registerSetting($class);
  }

  /**
   * {@inheritdoc}
   */
  public static function set(string $class, mixed $setting_value): void {
    try {
      if (!is_subclass_of($class, BaseStaticSettingInterface::class)) {
        throw new \Exception('Class must implement BaseStaticSettingInterface: ' . $class);
      }
      $setting_name = $class::settingName();
      if (!isset(self::$registeredValues[$setting_name])) {
        throw new \Exception('Class not registered: ' . $class);
      }

      // Add validation for enum values.
      if (!$setting_value instanceof $class) {
        throw new \Exception('Invalid value for enum ' . $class);
      }

      static::$values[$setting_name] = $setting_value;
    }
    catch (\Throwable $e) {
      throw new InvalidStaticSettingsException($e->getMessage());
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function get(string $class): ?BaseStaticSettingInterface {
    try {
      if (!is_subclass_of($class, BaseStaticSettingInterface::class)) {
        throw new \Exception('Class must implement BaseStaticSettingInterface: ' . $class);
      }
      $setting_name = $class::settingName();
      if (!isset(self::$registeredValues[$setting_name])) {
        throw new \Exception('Class not registered: ' . $class);
      }
      return static::$values[$setting_name] ?? NULL;
    }
    catch (\Throwable $e) {
      throw new InvalidStaticSettingsException($e->getMessage());
    }
  }

}
