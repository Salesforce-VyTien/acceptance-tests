<?php

// Acceptance tests for sustainer management features.
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Update the amount of a recurring donation.');

$I->amOnPage(DonationFormPage::$URL);
$I->makeADonation(array(), true);

$I->am('admin');
$I->login();

$I->amOnPage('springboard/donations');

// Click through to the sustainer management page from the orders screen.
$I->click('.views-row-first li.commerce-order-view.first a');
$I->click('Recurring donation set');
$I->click('Edit donation set');
$I->see('Recurring Payment Info', 'h2');

// Change the donation amount to $50.
$amount = 50;
$I->fillField(\SustainerManagementPage::$donationAmountField, $amount);
$I->click(\SustainerManagementPage::$donationAmountUpdateButton);
$I->see('The amount of all future donations has been updated to ' . $amount . '.', 'div');

// Change the charge date on all future orders to the 15.
$I->selectOption(\SustainerManagementPage::$chargeDateField, 15);
$I->click(\SustainerManagementPage::$chargeDateUpdateButton);
$I->see('The date of all future donations has been updated', 'div');

// Change the billing address for future orders.
$I->fillField(\SustainerManagementPage::$creditCardNumberField, '5555555555554444');
$I->selectOption(\SustainerManagementPage::$expirationMonthField, '1');
$I->selectOption(\SustainerManagementPage::$expirationYearField, '2016');
$I->fillField(\SustainerManagementPage::$cvvField, '123');
$I->click(\SustainerManagementPage::$billingUpdateButton);
$I->see('Billing information successfully updated', 'div');
//$I->see('01/15/16', 'td'); //@todo: bug, see ticket 1122.

// Cancel all remaining donations.
$I->fillField(\SustainerManagementPage::$reasonField, 'I no longer support your mission.');
$I->click(\SustainerManagementPage::$canelButton);
$I->see('All future payments cancelled.');
$I->see('There are no further charges for this recurring donation.');




