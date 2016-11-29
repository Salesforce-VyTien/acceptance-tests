<?php
// @env chrome_selenium
// @group npr
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add Payflow payment gateways.');
$I->am('admin');
$I->login();

$page = new PayflowPage($I);

// Configure regular.
$page->configureEFT(array(
  'new' => TRUE,
  'transaction_mode' => 'test',
  'verbose_gateway' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Payflow EFT');

// Configure recurring billing.
$page->configureEFT(array(
  'new' => TRUE,
  'transaction_mode' => 'test',
  'recurring_billing' => TRUE,
  'verbose_gateway' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Payflow EFT, recurring');
