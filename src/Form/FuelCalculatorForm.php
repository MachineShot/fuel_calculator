<?php

/**
 * @file
 * Contains \Drupal\fuel_calculator\Form\FuelCalculatorForm.
 */

namespace Drupal\fuel_calculator\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class FuelCalculatorForm extends ConfigFormBase
{

  /**
   * {@inheritdoc}.
   */
  public function getFormId()
  {
    return 'fuelcalculator_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    // Form constructor
    $form = parent::buildForm($form, $form_state);
    // Default settings
    $config = $this->config('fuel_calculator.settings');

    // Distance travelled field
    $form['travelled'] = array(
      '#type' => 'number',
      '#title' => t('Distance travelled'),
      '#default_value' => $config->get('fuel_calculator.travelled'),
      '#description' => t('Enter distance travelled in km'),
      '#min' => 0,
      '#step' => 0.01,
    );
    // Fuel consumption field
    $form['consumption'] = array(
      '#type' => 'number',
      '#title' => t('Fuel consumption'),
      '#default_value' => $config->get('fuel_calculator.consumption'),
      '#description' => t('Enter fuel consumption in L/100km'),
      '#min' => 0,
      '#step' => 0.01,
    );
    // Price per Liter field
    $form['price'] = array(
      '#type' => 'number',
      '#title' => t('Price per Liter'),
      '#default_value' => $config->get('fuel_calculator.price'),
      '#description' => t('Enter price per Liter in EUR'),
      '#min' => 0,
      '#step' => 0.01,
    );

    return $form;
  }

  /**
   * {@inheritdoc}.
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $travelled = $form_state->getValue('travelled');
    $consumption = $form_state->getValue('consumption');
    $price = $form_state->getValue('price');
    if (!is_numeric($travelled) || floatval($travelled) < 0) {
      $form_state->setErrorByName('travelled', t('Please enter a valid number.'));
    }
    if (!is_numeric($consumption) || floatval($consumption) < 0) {
      $form_state->setErrorByName('consumption', t('Please enter a valid number.'));
    }
    if (!is_numeric($price) || floatval($price) < 0) {
      $form_state->setErrorByName('price', t('Please enter a valid number.'));
    }
  }

  /**
   * {@inheritdoc}.
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $config = $this->config('fuel_calculator.settings');
    $config->set('fuel_calculator.travelled', $form_state->getValue('travelled'));
    $config->set('fuel_calculator.consumption', $form_state->getValue('consumption'));
    $config->set('fuel_calculator.price', $form_state->getValue('price'));
    $config->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}.
   */
  protected function getEditableConfigNames()
  {
    return [
      'fuel_calculator.settings',
    ];
  }
}
