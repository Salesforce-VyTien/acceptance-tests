<?php
// @group npr
// Testpad 0001.
// Testpad 0003.
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add a donation to my cart and select a gift with a lower value.');

// Set a few variables
// Click this to select the amount.
$donation_amount_selector = "//*/input[@value=30.00]/parent::label";
$donation_amount = '$30.00';
$summary_selector = '.donation-amount';
$premium_selector_npr_tshirt = '#edit-submitted-npr-premiums-fundraiser-premium-add-to-cart-form-5';

// Prepare the form.
$I->am('admin');
$I->login();
$I->amOnPage('springboard/node/24/edit');
$I->makeScreenshot('before-prepare-form');
$I->fillField('#edit-amount-wrapper-donation-amounts-5-amount', '360');
$I->click('Save');

// Select donation.
$I->amOnPage('/');
$I->click($donation_amount_selector);
$I->expectTo('See my donation amount in the summary box.');
$I->see($donation_amount, $summary_selector);

// Add premium.
$I->click("$premium_selector_npr_tshirt a.expand-premium");
$I->click("$premium_selector_npr_tshirt #edit-submit");
$I->waitForText('ADDED', NULL, $premium_selector_npr_tshirt);
// The main assertion. That the amount didn't change.
$I->expectTo('See the same donation amount as before adding a premium');
$I->see($donation_amount, $summary_selector);

// @todo rest of Testpad 0003.
// Submit the donation as Bill Me Later.
// Confirm that the donation amount is correct ($30) on the confirmation screen,
// the email confirmation, and the Drupal order page.
