<?php
// @env chrome_selenium
// @group npr
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add Payflow payment gateways.');
$I->am('admin');
$I->login();

$sage = new PayflowPage($I);

// Configure auth & capture.
$sage->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'test',
  'transaction_type' => 'S',
  'recurring_billing_type' => 'pnref-token',
  'verbose_gateway' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Payflow CC - Sale');

// Configure auth-only.
$sage->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'test',
  'transaction_type' => 'A',
  'recurring_billing_type' => 'pnref-token',
  'verbose_gateway' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Payflow CC - Authorization');
