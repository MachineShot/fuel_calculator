<?php

namespace Drupal\Tests\fuel_calculator\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests for the Fuel Calculator module.
 * @group fuel_calculator
 */
class FuelCalculatorTests extends BrowserTestBase
{

  /**
   * Modules to install
   *
   * @var array
   */
  protected static $modules = array('fuel_calculator');
  protected $defaultTheme = 'stark';

  // A simple user
  private $user;

  // Perform initial setup tasks that run before every test method.
  public function setUp(): void
  {
    parent::setUp();
    $this->user = $this->DrupalCreateUser(array(
      'administer site configuration',
      'calculate fuel',
    ));
  }

  /**
   * Tests that the fuel calculator page can be reached.
   */
  public function testFuelCalculatorPageExists()
  {
    // Login
    $this->drupalLogin($this->user);

    // Generator test:
    $this->drupalGet('fuel_calculator/calculate/250/6.5/1.49');
    $this->assertSession()->statusCodeEquals(200);
  }

  /**
   * Tests the config form.
   */
  public function testConfigForm()
  {
    // Login
    $this->drupalLogin($this->user);

    // Access config page
    $this->drupalGet('admin/config/development/fuel_calculator');
    $this->assertSession()->statusCodeEquals(200);
    // Test the form elements exist and have defaults
    $config = \Drupal::config('fuel_calculator.settings');
    $this->assertSession()->fieldValueEquals(
      'travelled',
      250
    );
    $this->assertSession()->fieldValueEquals(
      'consumption',
      6.5
    );
    $this->assertSession()->fieldValueEquals(
      'price',
      1.49
    );

    // Test form submission
    $this->submitForm(
      [
        'travelled' => 100,
        'consumption' => 5.5,
        'price' => 1.59
      ],
      t('Save configuration'),
    );
    $this->assertSession()->responseContains(
      'The configuration options have been saved.',
      'The form was saved correctly.'
    );

    // Test the new values are there.
    $this->drupalGet('admin/config/development/fuel_calculator');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->fieldValueEquals(
      'travelled',
      100
    );
    $this->assertSession()->fieldValueEquals(
      'consumption',
      5.5
    );
    $this->assertSession()->fieldValueEquals(
      'price',
      1.59
    );
  }
}
