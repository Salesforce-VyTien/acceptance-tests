<?php
// @env chrome_selenium
// @group npr
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add Sage CC payment gateways.');
$I->am('admin');
$I->login();

$page = new SagePage($I);

// Configure auth & capture.
$page->configureCC(array(
  'new' => TRUE,
  'verbose_gateway' => TRUE,
  'transaction_type' => 'auth_capture',
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Sage CC - auth_capture');

// Configure auth & capture, cardonfile.
$page->configureCC(array(
  'new' => TRUE,
  'verbose_gateway' => TRUE,
  'transaction_type' => 'auth_capture',
  'cardonfile' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Sage CC - auth_capture, cardonfile');

// Configure auth-only.
$page->configureCC(array(
  'new' => TRUE,
  'verbose_gateway' => TRUE,
  'transaction_type' => 'authorize',
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Sage CC - authorize');

// Configure auth-only, cardonfile.
$page->configureCC(array(
  'new' => TRUE,
  'verbose_gateway' => TRUE,
  'transaction_type' => 'authorize',
  'cardonfile' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Sage CC - authorize, cardonfile');
