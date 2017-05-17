<?php

$I = new FunctionalTester($scenario);

list($firstName, $lastName, $email) = $I->randomInfo();

$I->amOnPage('/secure/one-time--default-ask--authnet');
$I->selectOption('//input[@name="submitted[donation][amount]"]', '20');
$I->fillField('submitted[donor_information][first_name]', $firstName);
$I->fillField('submitted[donor_information][last_name]', $lastName);
$I->fillField('submitted[donor_information][mail]', $email);
$I->fillField('submitted[billing_information][address]', '123 Test St');
$I->fillField('submitted[billing_information][city]', 'Durham');
$I->selectOption('submitted[billing_information][state]', 'NC');
$I->fillField('submitted[billing_information][zip]', '27517');
$I->fillField('submitted[payment_information][payment_fields][credit][card_number]', '4111111111111111');
$I->selectOption('submitted[payment_information][payment_fields][credit][expiration_date][card_expiration_year]', $I->twoYearsFromNow());
$I->selectOption('submitted[payment_information][payment_fields][credit][expiration_date][card_expiration_month]', '5');
$I->fillField('submitted[payment_information][payment_fields][credit][card_cvv]', '123');
$I->click('#edit-submit');
$I->seeCurrentURLMatches('/\/secure\/one\-time\-\-default\-ask\-\-authnet\/thank\-you\?sid\=\d+/');
$I->see('Amount: $20.00');
$I->see($firstName . ' ' . $lastName);
$I->see($email);
$I->see('123 Test St  Durham, NC 27517');
