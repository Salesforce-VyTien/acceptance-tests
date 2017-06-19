<?php

$I = new FunctionalTester($scenario);

list($firstName, $lastName, $email) = $I->randomInfo('Redirect');

// First submit the webform that will redirect to the donation form.
$I->amOnPage('/secure/redirect-exposed-nid-and-title-market-source');
$I->fillField('submitted[sbp_first_name]', $firstName);
$I->fillField('submitted[sbp_last_name]', $lastName);
$I->fillField('submitted[mail]', $email);
$I->fillField('submitted[sbp_address]', '251 Testing St');
$I->fillField('submitted[sbp_city]', 'Washington');
$I->selectOption('submitted[sbp_state]', 'DC');
$I->fillField('submitted[sbp_zip]', '20006');
$I->click('#edit-submit');

// Confirm the origin_nid value is in the URL.
$I->seeCurrentURLMatches('/\/secure\/redirectee\-exposed\-nid\-and\-title\-market\-source\?sid\=(\d+)&origin_nid\=(\d+)/');

// Grab the origin_nid value for later comparison.
$origin_nid = $I->grabFromCurrentUrl('/origin_nid\=(\d+)/');

// Now submit the donation form.
$I->selectOption('//input[@name="submitted[payment_information][payment_method]"]', 'credit');
$I->fillField('submitted[payment_information][payment_fields][credit][card_number]', '4111111111111111');
$I->selectOption('submitted[payment_information][payment_fields][credit][expiration_date][card_expiration_year]', $I->twoYearsFromNow());
$I->selectOption('submitted[payment_information][payment_fields][credit][expiration_date][card_expiration_month]', '5');
$I->fillField('submitted[payment_information][payment_fields][credit][card_cvv]', '123');
$I->click('#edit-submit');

// Confirm the tokens look correct, including the origin_nid token.
$I->see('Amount: $50.00');
$I->see($firstName . ' ' . $lastName);
$I->see($email);
$I->see('251 Testing St  Washington, DC 20006');
$I->see('Referring Form Nid: ' . $origin_nid);
