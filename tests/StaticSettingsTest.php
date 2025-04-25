<?php

declare(strict_types=1);

namespace StaticSettings\Tests;

use PHPUnit\Framework\TestCase;
use StaticSettings\InvalidStaticSettingsException;
use StaticSettings\StaticSettings;

/**
 * Test class for the Static Settings functionality.
 */
class StaticSettingsTest extends TestCase {

  /**
   * Reset static properties before each test to ensure a clean state.
   */
  protected function setUp(): void {
    $this->resetStaticProperties();
  }

  /**
   * Helper method to reset static properties using reflection.
   */
  private function resetStaticProperties(): void {
    $reflection = new \ReflectionClass(StaticSettings::class);

    $registeredValues = $reflection->getProperty('registeredValues');
    $registeredValues->setAccessible(TRUE);
    $registeredValues->setValue(NULL, []);

    $values = $reflection->getProperty('values');
    $values->setAccessible(TRUE);
    $values->setValue(NULL, []);
  }

  /**
   * Test that a value can be registered with a valid class.
   */
  public function testRegisterSetting(): void {
    StaticSettings::registerSetting(TestEnvironment::class);
    $this->expectNotToPerformAssertions();
  }

  /**
   * Test that you can register the same value with the same class.
   */
  public function testRegisterDuplicateValueWithSameClass(): void {
    StaticSettings::registerSetting(TestEnvironment::class);
    StaticSettings::registerSetting(TestEnvironment::class);
    $this->expectNotToPerformAssertions();
  }

  /**
   * Test that you cannot register the same setting name with a different class.
   */
  public function testRegisterDuplicateValueWithDifferentClass(): void {
    StaticSettings::registerSetting(TestEnvironment::class);

    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Value already registered with a different class.');

    StaticSettings::registerSetting(TestAnotherEnvironment::class);
  }

  /**
   * Test that a valid enum value can be set for a registered setting.
   */
  public function testSetValidValue(): void {
    StaticSettings::registerSetting(TestEnvironment::class);
    StaticSettings::set(TestEnvironment::class, TestEnvironment::Production);
    $this->expectNotToPerformAssertions();
  }

  /**
   * Test that setting an unregistered value registers the class, too.
   */
  public function testSetUnregisteredValue(): void {
    StaticSettings::set(TestEnvironment::class, TestEnvironment::Production);
    $this->expectNotToPerformAssertions();
  }

  /**
   * Test that a previously set value can be retrieved correctly.
   */
  public function testGetValidValue(): void {
    StaticSettings::registerSetting(TestEnvironment::class);
    StaticSettings::set(TestEnvironment::class, TestEnvironment::Production);

    $value = StaticSettings::get(TestEnvironment::class);
    $this->assertEquals(TestEnvironment::Production, $value);
  }

  /**
   * Test that attempting to get an unregistered value throws an exception.
   */
  public function testGetUnregisteredValue(): void {
    $this->expectException(InvalidStaticSettingsException::class);
    $this->expectExceptionMessage('Class not registered: ' . TestEnvironment::class);

    StaticSettings::get(TestEnvironment::class);
  }

  /**
   * Test that getting a registered but unset value returns null.
   */
  public function testGetNonExistentValue(): void {
    StaticSettings::registerSetting(TestEnvironment::class);

    $value = StaticSettings::get(TestEnvironment::class);
    $this->assertNull($value);
  }

  /**
   * Test that setting an invalid value for an enum throws an exception.
   */
  public function testSetInvalidEnumValue(): void {
    StaticSettings::registerSetting(TestEnvironment::class);

    $this->expectException(InvalidStaticSettingsException::class);
    $this->expectExceptionMessage('Invalid value for enum ' . TestEnvironment::class);

    StaticSettings::set(TestEnvironment::class, 'test');
  }

  /**
   * Test that multiple settings can be set at once.
   */
  public function testSetMultiple(): void {
    $settings = [
      TestEnvironment::class => TestEnvironment::Production,
      TestAnotherSetting::class => TestAnotherSetting::Value1,
    ];

    StaticSettings::setMultiple($settings);

    $this->assertEquals(TestEnvironment::Production, StaticSettings::get(TestEnvironment::class));
    $this->assertEquals(TestAnotherSetting::Value1, StaticSettings::get(TestAnotherSetting::class));
  }

}
