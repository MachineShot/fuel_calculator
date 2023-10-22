<?php

namespace Drupal\fuel_calculator\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a Fuel calculator block
 *
 * @Block(
 *   id = "fuel_calculator_block",
 *   admin_label = @Translation("Fuel calculator block"),
 *   category = @Translation("Forms")
 * )
 */
class FuelCalculatorBlock extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    // Return the form @ Form/FuelCalculatorBlockForm.php
    return \Drupal::formBuilder()->getForm('Drupal\fuel_calculator\Form\FuelCalculatorBlockForm');
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account)
  {
    return AccessResult::allowedIfHasPermission($account, 'calculate fuel');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $this->setConfigurationValue(
      'fuel_calculator_block_settings',
      $form_state->getValue('fuel_calculator_block_settings')
    );
  }
}
