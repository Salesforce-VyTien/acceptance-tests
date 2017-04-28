<?php
//@group dw;

$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('ensure donation line items are queued up for export to the data warehouse.');

$I->amOnPage('/content/designations-single-fund-group');

$I->amGoingTo('donate $25 to animal welfare');
$I->selectOption('#funds-select-1', 21);
$I->selectOption('#edit-submitted-designations-designation-box-1-default-amounts-1-25', 25);
$I->click('#add-1');
$I->expect('the animal welfare designation to be added to my cart');
$I->see('Animal Welfare', 'td.fund-name');

$I->amGoingTo('donate $50 to natural disasters');
$I->selectOption('#funds-select-1', 23);   
$I->selectOption('#edit-submitted-designations-designation-box-1-default-amounts-1-50', 50);
$I->click('#add-1');
$I->expect('the natural disasters designation to be added to my cart');
$I->see('Natural Disasters', 'td.fund-name');

$I->amGoingTo('fill out the donation form and submit');
$I->fillField(DonationFormPage::$firstNameField, 'Johnny');
$I->fillField(DonationFormPage::$lastNameField, 'Donor');
$I->fillField(DonationFormPage::$emailField, 'johnny.donor@example.com');
$I->fillField(DonationFormPage::$addressField, '1260 Pointe Lane');
$I->fillField(DonationFormPage::$cityField, 'Farmington');
$I->selectOption(DonationFormPage::$stateField, 'ME');
$I->selectOption(DonationFormPage::$countryField, 'US');
$I->fillField(DonationFormPage::$zipField, '04938');
$I->fillField(DonationFormPage::$creditCardNumberField, '4111111111111111');
$I->selectOption(DonationFormPage::$creditCardExpirationMonthField, date('n'));
$I->selectOption(DonationFormPage::$creditCardExpirationYearField, date('Y') + 1);
$I->fillField(DonationFormPage::$CVVField, '123');
$I->expect('the donation to process succesfully');
$I->click('#edit-submit');
$I->see('Thank you, your submission has been received.');

$I->expect('7 items queued for the data warehouse');
$I->seeNumRecords(7, 'queue', ['name' => 'springboard_dw_export']);
