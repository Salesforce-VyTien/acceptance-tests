<?php
// @env chrome_selenium
// @group npr
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add Sage EFT payment gateways.');
$I->am('admin');
$I->login();

$sage = new SagePage($I);

// Configure regular.
$sage->configureEFT(array(
  'new' => TRUE,
  'verbose_gateway' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Sage EFT');

// Configure with cardonfile.
$sage->configureEFT(array(
  'new' => TRUE,
  'verbose_gateway' => TRUE,
  'cardonfile' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Sage EFT, cardonfile');
