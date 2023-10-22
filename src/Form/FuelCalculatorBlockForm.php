<?php

/**
 * @file
 * Contains \Drupal\fuel_calculator\Form\BlockFormController
 */

namespace Drupal\fuel_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Fuel Calculator block form
 */
class FuelCalculatorBlockForm extends FormBase
{
  /** 
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'fuel_calculator_block_form';
  }

  /**
   * {@inheritdoc}
   * Fuel Calculator form generator block.
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
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

    // Submit
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Calculate'),
    );

    // Reset
    $form['actions']['reset'] = array(
      '#type' => 'submit',
      '#value' => t('Reset'),
      '#submit' => array('::resetForm'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
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
   * {@inheritdoc}
   * Redirects users to the results page using the provided parameters.
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $form_state->setRedirect(
      'fuel_calculator.calculate',
      array(
        'travelled' => $form_state->getValue('travelled'),
        'consumption' => $form_state->getValue('consumption'),
        'price' => $form_state->getValue('price'),
      )
    );
  }

  /**
   * {@inheritdoc}
   * 
   * Resets the form with default values
   */
  public function resetForm(array &$form, FormStateInterface $form_state)
  {
    $form_state->setRebuild(false);
  }
}
