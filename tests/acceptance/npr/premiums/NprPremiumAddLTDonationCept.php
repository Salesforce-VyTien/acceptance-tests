<?php
// @group npr
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add a donation to my cart and select a gift with a lower value.');
$I->amOnPage('/');

// Set a few variables
// Click this to select the amount.
$donation_amount_selector = "label[for='edit-submitted-donation-amount-7']";
$donation_amount = '$15.00';
$summary_selector = '.donation-amount';
$premium_selector_npr_tshirt = '#edit-submitted-npr-premiums-fundraiser-premium-add-to-cart-form-5';

// Select donation.
$I->click($donation_amount_selector);
$I->see($donation_amount, $summary_selector);

// Add premium.
$I->click("$premium_selector_npr_tshirt a.expand-premium");
$I->click("$premium_selector_npr_tshirt #edit-submit");
$I->waitForText('ADDED', NULL, $premium_selector_npr_tshirt);
// The main assertion. That the amount didn't change.
$I->see($donation_amount, $summary_selector);
