<?php

namespace Drupal\mcs_register_button\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm.
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'mcs_register_button.config',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mcs_cas_links_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('mcs_register_button.config');
    $form['cas_sso_login_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CAS sso login link title'),
      '#maxlength' => 64,
      '#size' => 32,
      '#default_value' => $config->get('cas_sso_login_title'),
      '#required' => TRUE,
    ];
    $form['cas_sso_login_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CAS sso login path'),
      '#maxlength' => 255,
      '#size' => 255,
      '#default_value' => $config->get('cas_sso_login_path'),
      '#required' => TRUE,
    ];
    $form['cas_sso_logout_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CAS sso logout link title'),
      '#maxlength' => 64,
      '#size' => 32,
      '#default_value' => $config->get('cas_sso_logout_title'),
      '#required' => TRUE,
    ];
    $form['cas_sso_logout_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CAS sso logout path'),
      '#maxlength' => 255,
      '#size' => 255,
      '#default_value' => $config->get('cas_sso_logout_path'),
      '#required' => TRUE,
    ];


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    if(preg_match('/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/i' ,$form_state->getValue('cas_sso_login_path')) == 0 && preg_match('/^\/.*?$/i' ,$form_state->getValue('cas_sso_login_path')) == 0 ) {
      $form_state->setErrorByName('cas_login_path', $this->t('The CAS sso login path has to be a absolute (beginning with http(s)://) or a path absolute url (beginning with /).'));
    }

    if(preg_match('/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/i' ,$form_state->getValue('cas_sso_logout_path')) == 0 && preg_match('/^\/.*?$/i' ,$form_state->getValue('cas_sso_logout_path')) == 0 ) {
      $form_state->setErrorByName('cas_logout_path', $this->t('The CAS sso logout path has to be a absolute (beginning with http(s)://) or a path absolute url (beginning with /).'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('mcs_register_button.config')
      ->set('cas_sso_login_title', $form_state->getValue('cas_sso_login_title'))
      ->set('cas_sso_logout_title', $form_state->getValue('cas_sso_logout_title'))
      ->set('cas_sso_login_path', $form_state->getValue('cas_sso_login_path'))
      ->set('cas_sso_logout_path', $form_state->getValue('cas_sso_logout_path'))
      ->save();
  }

}
