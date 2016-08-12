<?php
$scenario->group('fundraiser');
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Enable and configure the quick donate module.');

$I->am('admin');
$I->login();
$I->configureSecurePrepopulate('7576586e4a5cb0611e3a1f080a30615a', 'cae023134cfcbf45');
$I->configureEncrypt();
$I->configureAuthnetCreditGateway();

$I->enableModule('Fundraiser Quick Donate');

$I->wantTo('Enable quick donate on a donation form.');
$I->amOnPage(DonationFormPage::route('/edit'));
$I->click('Payment methods');

$I->selectOption('#edit-gateways-credit-id', 'authnet_aim|commerce_payment_authnet_aim');
$I->waitForElement('#edit-quickdonate', 5);
$I->checkOption('#edit-quickdonate');
$I->seeElement('#edit-quickdonate-optin-message');
$I->seeElement('#edit-quickdonate-help-message-value');
$I->seeElement('#edit-quickdonate-login-message');
$I->seeElement('#edit-quickdonate-login-link-message');
$I->click('Save');

$I->logout();

$I->wantTo('Donate and opt into the quick donate program.');
$I->amOnPage(DonationFormPage::$URL);
$I->see('Save this card for future use');
$I->see('Already have a saved card?');
$I->see('Click here to login');
$I->seeElement('#edit-submitted-payment-information-payment-fields-credit-quickdonate');

$I->makeADonation(array('#edit-submitted-payment-information-payment-fields-credit-quickdonate' => array('type' => 'checkbox', 'value' => 1)));

// Assert the card on file record exists.
$I->seeInDatabase('commerce_cardonfile', array('card_id' => 1, 'uid' => 2, 'payment_method' => 'authnet_aim', 'card_type' => 'visa', 'card_name' => 'John Tester', 'card_number' => 1111, 'instance_id' => 'authnet_aim|commerce_payment_authnet_aim'));
// Assert the quick donate record exists.
$I->seeInDatabase('fundraiser_quick_donate_cardonfile', array('qd_id' => 1, 'status' => 1, 'card_id' => 1, 'uid' => 2, 'did' => 1, 'nid' => 2, 'gateway' => 'authnet_aim|commerce_payment_authnet_aim')); 

$I->am('admin');
$I->login();
$I->setAUsersPassword(2);
$I->logout();

$I->am('donor');
$I->login('bob@example.com', 'password');
$I->amOnPage('user/2/edit');
// Assert quick donate opt-in date is stored on the user's profile.
$I->canSeeInField('#edit-field-quick-donate-opt-in-und-0-value-date', date('m/d/Y'));

$I->amOnPage(DonationFormPage::$URL);
$I->see('Select a stored card');
$I->see('Use a different credit card');
$I->selectOption('#edit-submitted-payment-information-payment-fields-credit-cardonfile-1', 1);
$I->selectOption('#edit-submitted-donation-amount-4', 100);
$I->click('Donate');
