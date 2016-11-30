<?php
// @env chrome_selenium
// @group npr
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add Payflow CC payment gateways.');
$I->am('admin');
$I->login();

$page = new PayflowPage($I);

// Configure auth & capture.
$page->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'test',
  'transaction_type' => 'S',
  'recurring_billing_type' => 'pnref-token',
  'verbose_gateway' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Payflow CC - Sale, PNREF Token');

// Configure auth & capture.
$page->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'test',
  'transaction_type' => 'S',
  'recurring_billing_type' => 'recurring-billing-profile',
  'verbose_gateway' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Payflow CC - Sale, Recurring Billing Profile');

// Configure auth-only.
$page->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'test',
  'transaction_type' => 'A',
  'recurring_billing_type' => 'pnref-token',
  'verbose_gateway' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Payflow CC - Authorization, PNREF Token');

// Configure auth-only with recurring profile.
$page->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'test',
  'transaction_type' => 'A',
  'recurring_billing_type' => 'recurring-billing-profile',
  'verbose_gateway' => TRUE,
));
$I->see('NPR Payflow CC - Authorization, Recurring Billing Profile');
