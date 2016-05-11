<?php
$scenario->group('fundraiser');


$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Test enhanced gateway options.');

$title = 'fundraiser paypal enhancements ' . time();

$I->am('admin');
$I->login();
$I->configureEncrypt();
$paypal = new PayPalPage($I);
$paypal->configurePaypal();
$I->click('Enable payment method: PayPal WPS');

$I->fillField('#edit-parameter-payment-method-settings-payment-method-settings-submit-text', 'Donate on Paypal');
$I->fillField('#edit-parameter-payment-method-settings-payment-method-settings-selected-image', 'misc/druplicon.png');
$I->fillField('#edit-parameter-payment-method-settings-payment-method-settings-unselected-image', 'misc/druplicon.png');
$I->fillField('#edit-parameter-payment-method-settings-payment-method-settings-standalone-image', 'misc/druplicon.png');
$I->click('Save');
$I->acceptPopup();


$I->amOnPage('node/2/edit');
$I->click('Payment methods');
$I->unCheckOption('#edit-gateways-credit-status');
$I->checkOption('#edit-gateways-paypal-status');
$I->click('Save');

$I->amOnPage('node/2');
$I->seeElement('//input[@value="Donate"]');
$I->amOnPage('springboard/node/2/form-components/confirmation-page-settings');
$I->click('Advanced settings');
$I->fillField('#edit-submit-text', '');
$I->click('Save configuration');
$I->amOnPage('node/2');
$I->seeElement('//input[@value="Donate on Paypal"]');