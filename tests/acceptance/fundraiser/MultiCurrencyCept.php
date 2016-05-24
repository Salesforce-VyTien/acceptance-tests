<?php
$scenario->group('fundraiser');


$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Test fundraiser dual ask amount functions.');

$title = 'fundraiser dual ask test ' . time();

$I->am('admin');
$I->login();
$I->configureEncrypt();
$I->amOnPage(MultiCurrencyPage::$URL);
$I->selectOption(MultiCurrencyPage::$select, MultiCurrencyPage::$eur);
$I->click(MultiCurrencyPage::$adminFieldset);
$I->checkOption(MultiCurrencyPage::$eur);
$I->click(MultiCurrencyPage::$configSave);
$I->amOnPage(MultiCurrencyPage::$node . '/edit');
$I->selectOption(MultiCurrencyPage::$nodeSelect, MultiCurrencyPage::$eur);
$I->checkOption(DonationFormEditPage::$otherAmountField);
$I->click('Save');
$I->amOnPage('node/2/form-components/confirmation-page-settings');
$I->fillField(WebformPage::$confirmationMessage, ' [donation:currency:name], [donation:currency:code], [donation:currency:symbol]');
$I->click(WebformPage::$saveConfirm);
$I->amOnPage(DonationFormPage::$URL);
$I->see('€10');
$I->seeInPageSource('<div class="field-prefix">€</div>');
$I->logout();
$I->makeADonation();
$I->see('Euro, EUR, €');
$I->am('admin');
$I->login();
$I->amOnPage('springboard/donations/1');
$I->see('10,00 €', 'td.component-total');
$I->amOnPage('springboard/donations/1/payment');
$I->see('10,00 €');
$I->amOnPage('springboard/donations/1/edit');
$I->seeOptionIsSelected(MultiCurrencyPage::$paymentSelect, 'EUR');
$I->see('10,00 €', 'td.last');
$I->logout();
$I->makeADonation(array(), TRUE);
$I->am('admin');
$I->login();

$I->amOnPage('springboard/donations/2/recurring');
$I->see('10,00 €');
$I->amOnPage('springboard/donations/2/recurring/edit');
$I->see('10,00 €', '#payment-info');
$I->see('Your current donation amount is 10,00 €. Minimum donation 10,00 €');
$I->seeInPageSource('<div class="field-prefix">€</div>');
$I->amOnPage('springboard/user/2/recurring_overview');
$I->see('10,00 €', 'td.first');
$I->amOnPage('springboard/user/2/recurring_overview/2');
$I->see('10,00 €', '#payment-info');
$I->see('Your current donation amount is 10,00 €. Minimum donation 10,00 €');
$I->seeInPageSource('<div class="field-prefix">€</div>');
$I->fillField(MultiCurrencyPage::$editFee, '5');
$I->click('Update donation amount');
$I->see('Donation amount must be greater than 10,00 €');
