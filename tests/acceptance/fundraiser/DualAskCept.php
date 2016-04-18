<?php
$scenario->group('fundraiser');


$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Test fundraiser dual ask amount functions.');

$title = 'fundraiser dual ask test ' . time();

$I->am('admin');
$I->login();
$I->configureEncrypt();
//check server-side validation of payment method selection
$I->amOnPage(DonationFormPage::route('/edit'));
$I->seeOptionIsSelected("#edit-recurring-setting", "Donor chooses one-time or recurring");
$I->checkOption('#edit-recurring-dual-ask-amounts');
$I->click('Save');
$I->seeElement('#webform-component-donation--recurs-monthly');
$I->amOnPage(DonationFormPage::route('/edit'));
$I->seeElement('#fundraiser-recurring-ask-amounts-table');
$I->fillField('//input[@name="recurring_amount_wrapper[recurring_donation_amounts][0][amount]"]', 11);
$I->fillField('//input[@name="recurring_amount_wrapper[recurring_donation_amounts][1][amount]"]', 22);
$I->fillField('//input[@name="recurring_amount_wrapper[recurring_donation_amounts][2][amount]"]', 33);
$I->fillField('//input[@name="recurring_amount_wrapper[recurring_donation_amounts][3][amount]"]', 44);
$I->click('Save');
$I->click('.form-item-submitted-donation-recurs-monthly');
$I->click('.form-item-submitted-donation-recurs-monthly');

$I->wait(60);