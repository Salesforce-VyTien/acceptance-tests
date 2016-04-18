<?php
$scenario->group('fundraiser');


$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Test fundraiser edit page payment options.');

$title = 'fundraiser node edit test ' . time();

$I->am('admin');
$I->login();
$I->configureEncrypt();
//check server-side validation of payment method selection
$I->amOnPage(DonationFormPage::route('/edit'));
$I->click("Payment methods");
$I->uncheckOption('#edit-gateways-credit-status');
$I->click('#edit-submit');
$I->see('At least one payment method must be enabled.');
// select credit card method
$I->checkOption('#edit-gateways-credit-status');
//save and view webform
$I->click('#edit-submit');
$I->see('Credit card number');

$I->amOnPage(DonationFormPage::route('/edit'));

$I->amOnPage(DonationFormPage::route('/edit'));
$I->uncheckOption('Show other amount option');
$I->click('#edit-submit');
$I->dontSeeElement('#edit-submitted-donation-other-amount');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->checkOption('Show other amount option');
$I->click('#edit-submit');
$I->seeElement('#edit-submitted-donation-other-amount');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->fillField('Minimum donation amount', '');
$I->click('#edit-submit');
$I->see('Minimum payment');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->uncheckOption('Show other amount option');
$I->click('#edit-submit');
$I->dontSee('Minimum payment');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->fillField('#edit-amount-wrapper-donation-amounts-4-amount', '133');
$I->click('form');

$I->click('#edit-amount-wrapper-donation-amounts-4-label');
$I->wait(3);
$I->seeInField('#edit-amount-wrapper-donation-amounts-4-label','$133');

$I->checkOption('#edit-amount-wrapper-donation-amounts-4-default-amount');
$I->click('body');

$I->click('#edit-submit');

$I->seeCheckboxIsChecked('//input[@value="133"]');




