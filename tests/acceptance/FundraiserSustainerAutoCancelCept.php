<?php 
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Test auto-cancel of remaining, recurring payments when X number of failed payments is reached.');

$title = 'fundraiser recurring payments auto-cancel test ' . time();

// Log in to Drupal:
$I->am('admin');
$I->login();

// Ensure Fundraiser Sustainers module is enabled, as it implement the auto-cancellation feature:
$I->enableModule('Fundraiser Sustainers');

// Ensure Auto-cancel is enabled
$I->haveInDatabase('variable', array('name' => 'fundraiser_recurring_autocancel_enabled', 'value' => 'i:1;'));

// Get the number of payment failures (default is 3) to trigger auto-cancellation of any remaining payments:
$auto_cancel_failure_limit = $I->grabFromDatabase('variable', 'value', array('name' => 'fundraiser_recurring_autocancel_threshold'));
$auto_cancel_failure_limit = unserialize($auto_cancel_failure_limit);
if (!$auto_cancel_failure_limit) {
  $auto_cancel_failure_limit = 3;
}
codecept_debug('auto_cancel_failure_limit = "' . $auto_cancel_failure_limit . '"');

// Get the number of failed payment attempts (default is 3) before a failure status is achieved:
$single_payment_failure_limit = $I->grabFromDatabase('variable', 'value', array('name' => 'fundraiser_sustainers_max_processing_attempts'));
$single_payment_failure_limit = unserialize($single_payment_failure_limit);
if (!$single_payment_failure_limit) {
  $single_payment_failure_limit = 3;
}
codecept_debug('single_payment_failure_limit = "' . $single_payment_failure_limit . '"');

// Fill out the Donation form:
$I->amOnPage(DonationFormPage::$URL);
$I->fillField(DonationFormPage::$otherAmountField, '120');
$I->fillField(DonationFormPage::$firstNameField, 'The');
$I->fillField(DonationFormPage::$lastNameField, 'Batman');
$I->fillField(DonationFormPage::$emailField, 'somethingrandom@example.com');
$I->fillField(DonationFormPage::$addressField, '10 Fusion Drive');
$I->fillField(DonationFormPage::$addressField2, 'Suite Cool');
$I->fillField(DonationFormPage::$cityField, 'Jazzville');
$I->selectOption(DonationFormPage::$stateField, 'NY');
$I->selectOption(DonationFormPage::$countryField, 'US');
$I->fillField(DonationFormPage::$creditCardNumberField, '4111111111111111');
$I->fillField(DonationFormPage::$CVVField, '123');

// Using 55555 for simulated failure:
$I->fillField(DonationFormPage::$zipField, '55555');

// Get the number of payment failures (default 3) to trigger auto-cancellation of any remaining payments:
$auto_cancel_failure_limit = $I->grabFromDatabase('variable', 'value', array('name' => 'fundraiser_recurring_autocancel_threshold'));
$auto_cancel_failure_limit = unserialize($auto_cancel_failure_limit);
if (!$auto_cancel_failure_limit) {
  $auto_cancel_failure_limit = 3;
}
codecept_debug('auto_cancel_failure_limit = "' . $auto_cancel_failure_limit . '"');

// Get the number of failed payment attempts before a failure status is achieved:
$single_payment_failure_limit = $I->grabFromDatabase('variable', 'value', array('name' => 'fundraiser_sustainers_max_processing_attempts'));
$single_payment_failure_limit = unserialize($single_payment_failure_limit);
if (!$single_payment_failure_limit) {
  $single_payment_failure_limit = 3;
}
codecept_debug('single_payment_failure_limit = "' . $single_payment_failure_limit . '"');

// Based on the default number of failures, set card expiration date so that 2 future payments
// end up getting auto-cancelled after auto-cancellation is triggered:
/* $month = 6; $year = 2017;
$I->selectOption(DonationFormPage::$creditCardExpirationMonthField, $month);
$I->selectOption(DonationFormPage::$creditCardExpirationYearField, $year);
*/

// Submit the donation and ensure it submits successfully:

// View the Commerce orders list and get the master order ID from the top item's link:

// Open the recurring payments edit page:

// Trigger cancellation:
/* for ($i = 0; $i < $auto_cancel_failure_limit; $i++) {
  // Advance the next payment until a failed state is expected to be seen:
  for ($j = 0; $j < $single_payment_failure_limit; $j++) {
    // Confirm each failure is achieved as expected:
    // Confirm the associated Salesforce sync update is inserted into the salesforce_sync table:
  }
} */

// Confirm the 2 remaining payments have a status of auto-cancelled:




