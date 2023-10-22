<?php

/**
 * @file
 * Contains Drupal\fuel_calculator\Service\FuelCalculatorService
 */

namespace Drupal\fuel_calculator\Service;

use Drupal\Component\Utility\Html;
use Symfony\Component\HttpFoundation;

/**
 * Service layer for Fuel Calculator.
 */
class FuelCalculatorService
{
  /**
   * Calculates fuel spent and cost
   * 
   * @param float $travelled
   *  Distance traveled in km
   * @param float $consumption
   *  Fuel consumption in L/100km
   * @param float $price
   *  Price per Liter in EUR
   */
  public function calculate($travelled, $consumption, $price)
  {
    $fuel_spent = ($travelled * $consumption) / 100;
    $fuel_cost = $fuel_spent * $price;

    $element['#fuel_spent'] = round($fuel_spent, 1);
    $element['#fuel_cost'] = round($fuel_cost, 1);

    // Theme function
    $element['#theme'] = 'fuel_calculator';

    $user = \Drupal::currentUser()->getAccountName();
    $ip = \Drupal::request()->getClientIp();
    $message = 'IP: ' . $ip . ' User: ' . $user . ' Travelled: ' . $travelled .
      ' Consumption: ' . $consumption . ' Price: ' . $price .
      ' Fuel spent: ' . $fuel_spent . ' Fuel Cost: ' . $fuel_cost;
    \Drupal::logger('fuel_calculator')->info($message);

    return $element;
  }
}
