<?php 
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Test auto-cancel of remaining, recurring payments when X number of failed payments is reached.');

$master_did = 1; // We know the master_did will be 1 based on contents of the DB dump.

$title = 'fundraiser recurring payments auto-cancel test ' . time();

// Log in to Drupal:
$I->am('admin');
$I->login();

// Update the Secure Key Path:
$I->amOnPage('admin/config/system/encrypt');
$I->fillField('#edit-encrypt-secure-key-path', 'sites/default/secure');
$I->click('#edit-submit');

// Ensure Fundraiser Sustainers module is enabled, as it implements the auto-cancellation feature:
$I->enableModule('Fundraiser Sustainers');

// Ensure Auto-cancel is enabled:
$I->amOnPage('admin/config/system/fundraiser');
$I->wait(2);
$I->click('Fundraiser sustainers');
$I->wait(1);
$I->checkOption('#edit-fundraiser-recurring-autocancel-enabled');
$I->wait(1);
$I->seeCheckboxIsChecked('input#edit-fundraiser-recurring-autocancel-enabled');

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
$year = date('Y');
$month = date('n') + $auto_cancel_failure_limit + 2;
if ($month > 12) {
  $month = 12 - $month;
  $year++;
}
$I->selectOption(DonationFormPage::$creditCardExpirationMonthField, $month);
$I->selectOption(DonationFormPage::$creditCardExpirationYearField, $year);

// Make it a recurring donation:
$I->click('#edit-submitted-payment-information-recurs-monthly-1');

// Submit the donation and ensure it submits successfully:
$I->click('#edit-submit');

// Confirm the initial payment was created:
$I->seeInMessages('Donation was successfully processed.');
$I->seeInDatabase('commerce_order', array('order_id' => $master_did, 'status' => 'payment_received'));

// Trigger cancellation:
$current_did = $master_did + 1;
for ($i = 0; $i < $auto_cancel_failure_limit; $i++) {
  // Advance the next payment until a failed state is expected to be seen:
  for ($j = 0; $j < $single_payment_failure_limit; $j++) {
    codecept_debug('Advancing charge ' . ($i + 1) . ' - ' . ($j + 1));
    $I->amOnPage('fundraiser_sustainers/ffwd/' . $current_did . '?destination=/');
    $I->amOnPage('admin/reports/status/run-cron');
  }

  // Confirm a failed state was achieved:
  $I->seeInMessages('Donation transaction failed.');
  $I->seeInDatabase('commerce_order', array('order_id' => $current_did, 'status' => 'failed'));

  $current_did++;
} 

// Confirm the 2 remaining payments have a status of auto-cancelled:
$I->seeInMessages('Your payment #' . $current_did . ' has been canceled.');
$I->seeInDatabase('commerce_order', array('order_id' => $current_did, 'status' => 'auto_canceled'));
$I->seeInMessages('Your payment #' . ($current_did + 1) . ' has been canceled.');
$I->seeInDatabase('commerce_order', array('order_id' => $current_did + 1, 'status' => 'auto_canceled'));


$I->wait(1);

