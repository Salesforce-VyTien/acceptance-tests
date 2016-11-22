<?php

class AuthorizenetPage {

  /**
   * @var AcceptanceTester;
   */
  protected $acceptanceTester;

  public function __construct(AcceptanceTester $I) {
    $this->acceptanceTester = $I;
  }

  /**
   * @return AuthorizenetPage.
   */
  public static function of(AcceptanceTester $I) {
    return new static($I);
  }

  /**
   * Configure Authorize.net gateway.
   *
   * @param array $options
   *   Override any of the $default_options.
   */
  function configureCC($options = array()) {
    $default_options = array(
      'new' => FALSE,
      'transaction_mode' => 'developer',
      'transaction_type' => 'authorize',
      'cardonfile' => FALSE,
    );
    $transaction_modes = array(
      'live' => 'Live transactions in a live account',
      'live_test' => 'Test transactions in a live account',
      'developer' => 'Developer test account transactions',
    );
    $transaction_types = array(
      'auth_capture' => 'Authorization and capture',
      'authorize' => 'Authorization only (requires manual or automated capture after checkout)',
    );
    // Merge defaults with those passed.
    $options = array_merge($default_options, $options);
    // Selectors and names.
    $id_prefix = '#edit-parameter-payment-method-settings-payment-method-settings-';
    $id_payments_settings = 'commerce-sage-payments-settings-';
    $transaction_mode_field = 'form input[name="parameter[payment_method][settings][payment_method][settings][txn_mode]"]';
    $transaction_type_field = 'form input[name="parameter[payment_method][settings][payment_method][settings][txn_type]"]';
    $id_base = $id_prefix . $id_payments_settings;
    $name_base = 'NPR Authorize.net CC - ';
    $name = $name_base . $options['transaction_type'];

    // Settings from .yml files.
    $config = \Codeception\Configuration::config();
    $settings = \Codeception\Configuration::suiteSettings('acceptance', $config);

    // The actions.
    $I = $this->acceptanceTester;
    if ($options['new']) {
      $I->amOnPage('/admin/commerce/config/payment-methods/add');
      $I->selectOption('#edit-method-id', 'Authorize.Net AIM - Credit Card');
      $I->fillField('#edit-settings-label', $name);
      $I->waitForText('npr_authorize_net_cc_' . $options['transaction_type']);
      $I->fillField('#edit-settings-tags', 'NPR');
      $I->click('Save');
    }
    else {
      $I->amOnPage('/admin/commerce/config/payment-methods');
      $I->click($name);
    }

    $I->click('Enable payment method: Authorize.Net AIM - Credit Card');
    $I->fillField($id_prefix . 'login', $settings['Authorize.net']['api_login']);
    $I->fillField($id_prefix . 'tran-key', $settings['Authorize.net']['transaction_key']);
    $I->selectOption($transaction_mode_field, $transaction_modes[$options['transaction_mode']]);
    $I->selectOption($transaction_type_field, $transaction_types[$options['transaction_type']]);
    if ($options['cardonfile']) {
      $I->checkOption($id_prefix . 'cardonfile');
    }
    else {
      $I->uncheckOption($id_prefix . 'cardonfile');
    }
    $I->checkOption($id_prefix . 'log-request');
    $I->checkOption($id_prefix . 'log-response');
    $I->click('Save');
    $I->acceptPopup();
    $I->waitForText('Your changes have been saved.');
  }
}
