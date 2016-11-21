<?php

class PayflowPage {

  /**
   * @var AcceptanceTester;
   */
  protected $acceptanceTester;

  public function __construct(AcceptanceTester $I) {
    $this->acceptanceTester = $I;
  }

  /**
   * @return PayflowPage.
   */
  public static function of(AcceptanceTester $I) {
    return new static($I);
  }

  /**
   * Configure Payflow gateway.
   *
   * @param array $options
   *   Override any of the $default_options.
   */
  function configureCC($options = array()) {
    $default_options = array(
      'new' => FALSE,
      'transaction_mode' => 'test',
      'transaction_type' => 'A',
      'recurring_billing_type' => 'pnref-token',
      'verbose_gateway' => FALSE,
    );
    $transaction_modes = array(
      'test' => 'Test - process test transactions to an account in test mode',
      'live' => 'Live - process real transactions to a live account',
    );
    $transaction_types = array(
      'S' => 'Sale - authorize and capture the funds at the time the payment is processed',
      'A' => 'Authorization - reserve funds on the card to be captured later through your PayPal account',
    );
    $recurring_billing_types = array(
      'pnref-token' => 'PNREF Token (Uses previous payment tokens to make reference charges)',
      'recurring-billing-profile' => 'Recurring Billing Profile (requires add-on service in Payflow account)',
    );
    // Merge defaults with those passed.
    $options = array_merge($default_options, $options);
    // Selectors and names.
    $id_prefix = '#edit-parameter-payment-method-settings-payment-method-settings-';
    $transaction_mode_field = 'form input[name="parameter[payment_method][settings][payment_method][settings][mode]"]';
    $transaction_type_field = 'form input[name="parameter[payment_method][settings][payment_method][settings][trxtype]"]';
    $recurring_billing_field = 'form input[name="parameter[payment_method][settings][payment_method][settings][recurring-billing]"]';
    $name = 'NPR Payflow CC - ';
    $suffix = '';
    switch ($options['transaction_type']) {
      case 'A':
        $suffix = 'Authorization';
        break;

      case 'S':
        $suffix = 'Sale';
        break;
    }
    $name = $name . $suffix;

    // Settings from .yml files.
    $config = \Codeception\Configuration::config();
    $settings = \Codeception\Configuration::suiteSettings('acceptance', $config);

    // The actions.
    $I = $this->acceptanceTester;
    if ($options['new']) {
      $I->amOnPage('/admin/commerce/config/payment-methods/add');
      $I->selectOption('#edit-method-id', 'Fundraiser Payflow Credit Card');
      $I->fillField('#edit-settings-label', $name);
      $I->waitForText('npr_payflow_cc_' . strtolower($suffix));
      $I->fillField('#edit-settings-tags', 'NPR');
      $I->click('Save');
    }
    else {
      $I->amOnPage('/admin/commerce/config/payment-methods');
      $I->click($name);
    }

    $I->click('Enable payment method: Fundraiser Payflow Credit Card');
    $I->fillField($id_prefix . 'partner', $settings['Payflow']['partner']);
    $I->fillField($id_prefix . 'vendor', $settings['Payflow']['merchant_login']);
    $I->fillField($id_prefix . 'user', $settings['Payflow']['user']);
    $I->fillField($id_prefix . 'password', $settings['Payflow']['password']);
    $I->selectOption($transaction_mode_field, $transaction_modes[$options['transaction_mode']]);
    $I->selectOption($transaction_type_field, $transaction_types[$options['transaction_type']]);
    $I->selectOption($recurring_billing_field, $recurring_billing_types[$options['recurring_billing_type']]);
    if ($options['verbose_gateway']) {
      $I->checkOption($id_prefix . 'verbose-errors');
    }
    else {
      $I->uncheckOption($id_prefix . 'verbose-errors');
    }
    $I->checkOption($id_prefix . 'log-request');
    $I->checkOption($id_prefix . 'log-response');
    $I->click('Save');
    $I->acceptPopup();
    $I->waitForText('Your changes have been saved.');
  }
}
