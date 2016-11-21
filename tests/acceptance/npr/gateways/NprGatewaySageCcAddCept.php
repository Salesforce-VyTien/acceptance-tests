<?php
// @env chrome_selenium
// @group npr
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add Sage payment gatewayss.');
$I->am('admin');
$I->login();

$sage = new SagePage($I);

// Configure auth & capture.
$sage->configureSageCC(array(
  'new' => TRUE,
  'verbose_gateway' => TRUE,
  'transaction_type' => 'auth_capture',
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Sage CC - auth_capture');

// Configure auth-only.
$sage->configureSageCC(array(
  'new' => TRUE,
  'verbose_gateway' => TRUE,
  'transaction_type' => 'authorize',
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Sage CC - authorize');
