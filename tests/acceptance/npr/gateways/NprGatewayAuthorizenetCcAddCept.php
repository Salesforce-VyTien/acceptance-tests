<?php
// @env chrome_selenium
// @group npr
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add Authorize.net payment gateways.');
$I->am('admin');
$I->login();

$sage = new AuthorizenetPage($I);

// Configure auth & capture.
$sage->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'developer',
  'transaction_type' => 'auth_capture',
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Authorize.net CC - auth_capture');

// Configure auth & capture, cardonfile.
$sage->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'developer',
  'transaction_type' => 'auth_capture',
  'cardonfile' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Authorize.net CC - auth_capture, cardonfile');

// Configure auth-only.
$sage->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'developer',
  'transaction_type' => 'authorize',
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Authorize.net CC - authorize');

// Configure auth-only, cardonfile.
$sage->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'developer',
  'transaction_type' => 'authorize',
  'cardonfile' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Authorize.net CC - authorize, cardonfile');
