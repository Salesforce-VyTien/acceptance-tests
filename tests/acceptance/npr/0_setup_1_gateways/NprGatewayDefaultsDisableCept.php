<?php
// @group npr
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Disable default payment gateways.');
$I->am('admin');
$I->login();

$I->amOnPage('admin/commerce/config/payment-methods/manage/17/revert');
$I->click('Confirm');
$I->amOnPage('admin/commerce/config/payment-methods/manage/26/revert');
$I->click('Confirm');
$I->amOnPage('admin/commerce/config/payment-methods/manage/27/revert');
$I->click('Confirm');
$I->amOnPage('admin/commerce/config/payment-methods');
$I->dontSee('Paypal Payflow Credit Card', '.rules-overview-table:nth-child(3)');
$I->see('Fundraiser Payflow Credit Card', '.rules-overview-table:nth-child(6)');
$I->dontSee('Paypal Payflow EFT', '.rules-overview-table:nth-child(3)');
$I->see('Fundraiser Payflow EFT', '.rules-overview-table:nth-child(6)');
$I->dontSee('Sage Payment - Credit Card', '.rules-overview-table:nth-child(3)');
$I->see('Sage Payment - Credit Card', '.rules-overview-table:nth-child(6)');
