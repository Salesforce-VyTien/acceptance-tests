<?php
// @group npr
$I = new \AcceptanceTester\NprSteps($scenario);
$I->wantTo('Disable default payment gateways.');
$I->am('admin');
$I->login();

// Make list of all gateways that are not "Test Gateway" or "Bill Me Later".
$skip = array(
  'Test Gateway',
  'Bill Me Later',
);
$paths = $I->activePaymentMethods($skip);

// Loop through the paths list and disable each rule.
foreach ($paths as $path) {
  // Disable the rule.
  $I->amOnPage($path);
  $I->click('#edit-settings a.fieldset-title');
  $I->waitForElementVisible('#edit-settings-active');
  $I->uncheckOption('#edit-settings-active');
  $I->click('Save changes');
  $I->see('Your changes have been saved', '.status');
}
