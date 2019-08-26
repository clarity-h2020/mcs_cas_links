<?php

namespace Drupal\mcs_register_button\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'RegisterButtonBlock' block.
 *
 * @Block(
 *  id = "register_button_block",
 *  admin_label = @Translation("Register button block"),
 * )
 */
class RegisterButtonBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
            'button_text' => "Register!",
          ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['button_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Button text'),
    '#description' => $this->t('The text of the register button'),
      '#default_value' => $this->configuration['button_text'],
      '#maxlength' => 64,
      '#size' => 32,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['button_text'] = $form_state->getValue('button_text');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['register_button_block_button_text']['#markup'] ='<div id="register-wrapper"><div><a class="btn btn-default btn-lg" href="https://profile.myclimateservices.eu/user/register">'. $this->t($this->configuration['button_text']) . 
    '</a></div></div>';
    $build['#attached']['library'][] = 'register_button/register-button';
    return $build;
  }

}
