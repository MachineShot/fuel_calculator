<?php

/**
 * @file
 * Contains \Drupal\fuel_calculator\Controller\FuelCalculatorController
 */

namespace Drupal\fuel_calculator\Controller;

use Drupal\Component\Utility\Html;
use Drupal\fuel_calculator\Service\FuelCalculatorService;

/**
 * Controller routines for Fuel calculator pages.
 */
class FuelCalculatorController
{

  /**
   * Calculates Fuel results with arguments.
   * This callback is mapped to the path
   * 'fuel_calculator/calculate/{travelled}/{consumption}/{price}'.
   *
   * @var \Drupal\fuel_calculator\Service\FuelCalculatorService $FuelCalculatorService
   *   A call to the Fuel calculator service.
   * @param float $distance
   *  Distance traveled in km
   * @param float $consumption
   *  Fuel consumption in L/100km
   * @param float $price
   *  Price per Liter in EUR
   */

  // The themeable element.
  protected $element = [];

  // The calculate method which stores fuel results in a themeable element.
  public function calculate($travelled, $consumption, $price)
  {
    $FuelCalculatorService = \Drupal::service('fuel_calculator.fuelcalculator_service');
    $element = $FuelCalculatorService->calculate($travelled, $consumption, $price);

    return $element;
  }
}
