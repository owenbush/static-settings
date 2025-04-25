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
    if (
      isset(self::$registeredValues[$class])
      && self::$registeredValues[$class] !== $class
    ) {
      throw new \Exception('Value already registered with a different class.');
    }
    self::$registeredValues[$class] = $class;
  }

  /**
   * {@inheritdoc}
   */
  public static function set(string $class, mixed $setting_value): void {
    try {
      if (!is_subclass_of($class, BaseStaticSettingInterface::class)) {
        throw new \Exception('Class must implement BaseStaticSettingInterface: ' . $class);
      }
      if (!isset(self::$registeredValues[$class])) {
        self::registerSetting($class);
      }

      // Add validation for enum values.
      if (!$setting_value instanceof $class) {
        throw new \Exception('Invalid value for enum ' . $class);
      }

      static::$values[$class] = $setting_value;
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
      if (!isset(self::$registeredValues[$class])) {
        throw new \Exception('Class not registered: ' . $class);
      }
      return static::$values[$class] ?? NULL;
    }
    catch (\Throwable $e) {
      throw new InvalidStaticSettingsException($e->getMessage());
    }
  }

}
