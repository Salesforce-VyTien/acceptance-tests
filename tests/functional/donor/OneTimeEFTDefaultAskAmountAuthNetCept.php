<?php

$I = new FunctionalTester($scenario);

list($firstName, $lastName, $email) = $I->randomInfo();

$I->amOnPage('/secure/one-time--default-ask--authnet');
$I->selectOption('//input[@name="submitted[donation][amount]"]', '50');
$I->fillField('submitted[donor_information][first_name]', $firstName);
$I->fillField('submitted[donor_information][last_name]', $lastName);
$I->fillField('submitted[donor_information][mail]', $email);
$I->fillField('submitted[billing_information][address]', '123 Test St');
$I->fillField('submitted[billing_information][city]', 'Durham');
$I->selectOption('submitted[billing_information][state]', 'NC');
$I->fillField('submitted[billing_information][zip]', '27517');
$I->selectOption('//input[@name="submitted[payment_information][payment_method]"]', 'bank account');
$I->fillField('submitted[payment_information][payment_fields][bank account][bank_name]', 'USAA');
$I->fillField('submitted[payment_information][payment_fields][bank account][aba_code]', '314074269');
$I->fillField('submitted[payment_information][payment_fields][bank account][acct_num]', '123456');
$I->fillField('submitted[payment_information][payment_fields][bank account][confirm_acct_num]', '123456');
$I->fillField('submitted[payment_information][payment_fields][bank account][acct_name]', 'Tester McTest');
$I->click('#edit-submit');
$I->seeCurrentURLMatches('/\/secure\/one\-time\-\-default\-ask\-\-authnet\/thank\-you\?sid\=\d+/');
$I->see('Amount: $50.00');
$I->see($firstName . ' ' . $lastName);
$I->see($email);
$I->see('123 Test St  Durham, NC 27517');
