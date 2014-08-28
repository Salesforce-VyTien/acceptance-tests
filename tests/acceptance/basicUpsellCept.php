<?php
$I = new AcceptanceTester($scenario);

$I->wantTo('complete an upsell.');
$I->amOnPage('/');
$I->see('DONATE');
$I->fillField('First Name', 'Your');
$I->fillField('Last Name', 'Mom');
$I->fillField('E-mail address', 'bob@example.com');
$I->fillField('Address', '1234 main st');
$I->fillField('City', 'Washington');
$I->selectOption('Country', 'United States');
$I->selectOption('State', 'District Of Columbia');
$I->fillField('ZIP/Postal Code', '20024');
$I->fillField('Credit card number', '4111111111111111');
$I->selectOption('#edit-submitted-payment-information-payment-fields-credit-expiration-date-card-expiration-month', 'January');

$exp_year = date('Y', strtotime('+ 1 year'));
$I->selectOption('#edit-submitted-payment-information-payment-fields-credit-expiration-date-card-expiration-year', $exp_year);

$I->fillField('CVV', '123');
$I->click('Donate');

$I->see('Monthly donation', '#modalContent');
$I->seeElement('#modalContent input[type=submit]');
$I->see('No thanks', '#modalContent');
$I->seeLink('No thanks');
$I->click('Yes, Sign Me Up!');

$I->waitForText('Close', 20, '#modalContent');
$I->click('Close', '#modalContent');
$I->see('Thank you for your donation!');
