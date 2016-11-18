<?php

class SagePage {

  /**
   * @var AcceptanceTester;
   */
  protected $acceptanceTester;

  public function __construct(AcceptanceTester $I) {
    $this->acceptanceTester = $I;
  }

  /**
   * @return SagePage.
   */
  public static function of(AcceptanceTester $I) {
    return new static($I);
  }

  /**
   * Configure Sage gateway.
   *
   * The main idea is that we will reconfigure the default sage gateway for each
   * test, rather than adding new instances.
   *
   * @param array $options
   *   Override any of the $default_options.
   */
  function configureSage($options = array()) {
    $default_options = array(
      'transaction_type' => 'authorize',
      'cardonfile' => FALSE,
      'verbose_gateway' => FALSE,
    );
    $transaction_types = array(
      'auth_capture' => 'Authorization and capture',
      'authorize' => 'Authorization only (requires manual or automated capture after checkout)',
    );
    // Merge defaults with those passed.
    $options = array_merge($default_options, $options);
    // Selectors.
    $id_prefix = '#edit-parameter-payment-method-settings-payment-method-settings-';
    $id_payments_settings = 'commerce-sage-payments-settings-';
    $transaction_type_field = 'form input[name="parameter[payment_method][settings][payment_method][settings][transaction_type]"]';
    $id_base = $id_prefix . $id_payments_settings;

    // Settings from .yml files.
    $config = \Codeception\Configuration::config();
    $settings = \Codeception\Configuration::suiteSettings('acceptance', $config);

    // The actions.
    $I = $this->acceptanceTester;
    $I->amOnPage('/admin/commerce/config/payment-methods');
    $I->click('Sage Payment - Credit Card');
    $I->click('Enable payment method: Sage Payment - Credit Card');
    $I->fillField($id_base . 'merchant-id', $settings['Sage']['merchant_id']);
    $I->fillField($id_base . 'merchant-key', $settings['Sage']['merchant_key']);
    $I->fillField($id_base . 'application-id', $settings['Sage']['application_id']);
    $I->selectOption($transaction_type_field, $transaction_types[$options['transaction_type']]);
    if ($options['cardonfile']) {
      $I->checkOption($id_prefix . 'cardonfile');
    }
    else {
      $I->uncheckOption($id_prefix . 'cardonfile');
    }
    if ($options['verbose_gateway']) {
      $I->checkOption($id_prefix . 'verbose-gateway');
    }
    else {
      $I->uncheckOption($id_prefix . 'verbose-gateway');
    }
    $I->checkOption($id_prefix . 'log-request');
    $I->checkOption($id_prefix . 'log-response');
    $I->click('Save');
    $I->acceptPopup();
    $I->waitForText('Your changes have been saved.');
  }
}
