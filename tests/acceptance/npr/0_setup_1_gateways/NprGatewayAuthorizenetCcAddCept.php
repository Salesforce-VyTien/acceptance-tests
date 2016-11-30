<?php
// @env chrome_selenium
// @group npr
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add Authorize.net CC payment gateways.');
$I->am('admin');
$I->login();

$page = new AuthorizenetPage($I);

// Configure auth & capture.
$page->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'developer',
  'transaction_type' => 'auth_capture',
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Authorize.net CC - auth_capture');

// Configure auth & capture, cardonfile.
$page->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'developer',
  'transaction_type' => 'auth_capture',
  'cardonfile' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Authorize.net CC - auth_capture, cardonfile');

// Configure auth-only.
$page->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'developer',
  'transaction_type' => 'authorize',
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Authorize.net CC - authorize');

// Configure auth-only, cardonfile.
$page->configureCC(array(
  'new' => TRUE,
  'transaction_mode' => 'developer',
  'transaction_type' => 'authorize',
  'cardonfile' => TRUE,
));
$I->amOnPage('/admin/commerce/config/payment-methods');
$I->see('NPR Authorize.net CC - authorize, cardonfile');
