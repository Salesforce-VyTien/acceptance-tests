<?php
// @group npr
// Testpad 0004.
$I = new \AcceptanceTester\NprSteps($scenario);
$I->wantTo('Add a premium then check "no thanks".');

// Set a few variables
// Click this to select the amount.
$donation_amount_selector = "//*/input[@value=30.00]/parent::label";
//XPath option: "//*/strong[contains(text(),'Receipt ID')]/../../td[@class='value']";
$donation_amount = '$30.00';
$summary_selector = '.donation-amount';
$premium_selector_npr_tshirt = '#edit-submitted-npr-premiums-fundraiser-premium-add-to-cart-form-5';

$I->amOnPage('/');
// Add premium.
$I->click("$premium_selector_npr_tshirt a.expand-premium");
$I->click("$premium_selector_npr_tshirt #edit-submit");
$I->waitForText('ADDED', NULL, $premium_selector_npr_tshirt);
$I->seeElement('.view-premium-donation-form-cart');
// Check No Thanks checkbox.
$I->checkOption('#edit-submitted-choose-an-optional-gift-1');
$I->waitForElementNotVisible($premium_selector_npr_tshirt);
$I->expectTo('See no premiums in the summary box');
$I->dontSeeElement('.view-premium-donation-form-cart');
