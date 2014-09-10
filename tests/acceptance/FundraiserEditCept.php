<?php
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('test fundraiser edit page payment options.');

$title = 'fundraiser node edit test ' . time();


$I->am('admin');
$I->login();

$I->amOnPage(DonationFormPage::route('/edit'));
$I->uncheckOption('#edit-gateways-credit-status');
$I->click(DonationFormPage::$donateButton);
$I->see('At least one payment method must be enabled.');
$I->checkOption('#edit-gateways-credit-status');
$I->click(DonationFormPage::$donateButton);
$I->see('Credit card number');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->uncheckOption('Ask for quantity');
$I->click(DonationFormPage::$donateButton);
$I->dontSeeElement('#edit-submitted-donation-quantity');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->checkOption('Ask for quantity');
$I->click(DonationFormPage::$donateButton);
$I->seeElement('#edit-submitted-donation-quantity');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->uncheckOption('Show other amount option');
$I->click(DonationFormPage::$donateButton);
$I->dontSeeElement('#edit-submitted-donation-other-amount');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->checkOption('Show other amount option');
$I->click(DonationFormPage::$donateButton);
$I->seeElement('#edit-submitted-donation-other-amount');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->fillField('Minimum donation amount', '');
$I->click(DonationFormPage::$donateButton);
$I->see('Minimum payment');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->uncheckOption('Show other amount option');
$I->click(DonationFormPage::$donateButton);
$I->dontSee('Minimum payment');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->fillField('#edit-amount-wrapper-donation-amounts-4-amount', '133');
$I->click('#edit-amount-wrapper-donation-amounts-4-label');
$I->seeInField('#edit-amount-wrapper-donation-amounts-4-label','$133');

$I->checkOption('#edit-default-amount--5');
$I->click(DonationFormPage::$donateButton);
$I->seeCheckboxIsChecked('#edit-submitted-donation-amount-5');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->selectOption('#edit-recurring-setting', 'never');
$I->click(DonationFormPage::$donateButton);
$I->dontSee('Recurring Payment');



