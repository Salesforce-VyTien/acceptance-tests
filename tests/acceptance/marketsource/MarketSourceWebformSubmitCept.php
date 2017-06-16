<?php
//@group marketsource

$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('test Market Source webform submit handler');

$I->am('admin');
$I->login();
$I->configureEncrypt();
$I->enableModule('Market Source');
$I->nid = $I->cloneADonationForm();
$I->internalName = $I->grabTextFrom('#edit-field-fundraiser-internal-name-und-0-value');

$I->click('Save');

$I->click('Form components', 'ul.primary');
$I->click('Confirmation page & settings', 'ul.secondary');

// Save redirect field here.
$I->checkOption('#edit-redirect-url');
$I->fillField('#edit-redirect-url--2', 'node/2');

// Save configuration.
$I->click('Save configuration');

$I->logout();

// Go to the cloned donation form.
$I->amOnPage('node/' . $I->nid);
$I->makeADonation(array('amount' => 10, 'first_name' => 'John', 'last_name' => 'Tester', 'mail' => 'bob@example.com'));

// Confirm that originating form nid and internal name are in the querystring.
$I->seeInCurrentUrl('origin_nid='. $I->nid);
$I->seeInCurrentUrl('origin_form_name='. $I->internalName);

// Create a confirmation webform.
$I->am('admin');
$I->login();
$I->nid = $I->cloneADonationForm();
$I->internalName = $I->grabTextFrom('#edit-field-fundraiser-internal-name-und-0-value');

// Save configuration.
$I->click('Save configuration');

$I->logout();

// Ensure that the form nid and internal name are not in the querystring.
$I->amOnPage('node/' . $I->nid);
$I->makeADonation(array('amount' => 10, 'first_name' => 'John', 'last_name' => 'Tester', 'mail' => 'bob@example.com'));

// Confirm that originating form nid and internal name are in the querystring.
$I->dontSeeInCurrentUrl('origin_nid='. $I->nid);
$I->dontSeeInCurrentUrl('origin_form_name='. $I->internalName);