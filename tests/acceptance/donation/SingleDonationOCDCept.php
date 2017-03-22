<?php

//@group donationocd;
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Submit a new non-recurring donation, enrolling in one-click donate.');
$title = 'donation single enroll one-click' . time();
$I->am('donator');
$I->login();

// Fill out fundraiser donation page form
$I->amOnPage(DonationOCDFormPage::$URL);
$I->fillField(DonationOCDFormPage::$otherAmountField, '120');
$I->fillField(DonationOCDFormPage::$firstNameField, 'Miles');
$I->fillField(DonationOCDFormPage::$lastNameField, 'Davis');
$I->fillField(DonationOCDFormPage::$emailField, 'md@example.com');
$I->fillField(DonationOCDFormPage::$addressField, '10 Fusion Drive');
$I->fillField(DonationOCDFormPage::$addressField2, 'Suite Cool');
$I->fillField(DonationOCDFormPage::$cityField, 'Jazzville');
$I->selectOption(DonationOCDFormPage::$stateField, 'NY');
$I->selectOption(DonationOCDFormPage::$countryField, 'US');
$I->fillField(DonationOCDFormPage::$zipField, '12345');
$I->fillField(DonationOCDFormPage::$creditCardNumberField, '4111111111111111');
$I->selectOption(DonationOCDFormPage::$creditCardExpirationMonthField, '6');
$I->selectOption(DonationOCDFormPage::$creditCardExpirationYearField, '2017');
$I->fillField(DonationOCDFormPage::$CVVField, '123');
$I->checkOption(DonationOCDFormPage::$ocdField);
$I->seeCheckboxIsChecked(DonationOCDFormPage::$ocdField);
$I->click('#edit-submit');
