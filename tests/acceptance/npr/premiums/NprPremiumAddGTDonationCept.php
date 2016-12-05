<?php
// @group npr
// Testpad 0002.
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Add a donation to my cart and select a gift with a lower value.');
$I->amOnPage('/');

// Set a few variables
// Click this to select the amount.
$donation_amount_selector = "label[for='edit-submitted-donation-amount-7']";
$donation_amount = '$15.00';
$summary_selector = '.donation-amount';
$premium_selector_world_cafe_cd = '#edit-submitted-npr-premiums-fundraiser-premium-add-to-cart-form-4';
$premium_amount_world_cafe_cd = '$25';

// Select donation.
$I->click($donation_amount_selector);
$I->see($donation_amount, $summary_selector);

// Add premium.
$I->click('.toggle-collapsed-label');
$I->waitForElementVisible("$premium_selector_world_cafe_cd a.expand-premium");
$I->click("$premium_selector_world_cafe_cd a.expand-premium");
$I->waitForElementVisible("$premium_selector_world_cafe_cd input[id^='edit-submit']");
$I->click("$premium_selector_world_cafe_cd input[id^='edit-submit']");
$I->waitForText('ADDED', NULL, $premium_selector_world_cafe_cd);
// The main assertion. That the amount changed.
$I->dontSee($donation_amount, $summary_selector);
$I->see($premium_amount_world_cafe_cd, $summary_selector);
$I->see("We've increased your donation");
