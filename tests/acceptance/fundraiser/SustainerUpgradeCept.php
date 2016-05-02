<?php
$scenario->group('fundraiser');


$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Test fundraiser sustainer upgrade.');

$title = 'fundraiser sustainer upgrade ' . time();

$I->am('admin');
$I->logIn();
$I->configureEncrypt();
$I->configureSecurePrepopulate('rSJ22SIRITmX9L7ikkLMVwqD90g9SSQg', 'OCb34r2i3tfMvPZD');
$I->enableModule('Fundraiser Sustainer Upgrade');

// Make donation.
$I->amOnPage('node/2');
$I->makeADonation(array('ask' => '10'), TRUE);
$I->see("Thank you John Tester for your donation of $10.00.");
$I->amOnPage('springboard/donations/1/payment');
// Grab donation date.
$date = $I->grabTextFrom('td.views-field-created');

// Test as logged in user
doSustainerSteps($I, $date);

//Test as  anon.
doSustainerSteps($I, $date, TRUE);

function doSustainerSteps($I, $date, $anon = FALSE) {

  // Generate a token.
  $url = $I->generateSustainerUpgradeToken($anon, "1001", 1, 1);

// Go to the upgrade form.
  $I->amOnUrl($url);

// Check form text and tokens.
  $I->see("Thank you John Tester. (Not John? Click here.) To upgrade your monthly donation to $10.01, click Confirm below.");
  $I->see("Your original donation for $10.00, was made on");
  $I->see($date);
  $I->see("with your card ending in 1111. You have 8 charges remaining in this series, which will be upgraded to $10.01");

// Submit.
  $I->click("#edit-submit");

// Check confirmation text.
  $I->see("Default Sustainers Upgrade Form");
  $I->see("Thank you John Tester for upgrading your sustaining donation to $10.01.");

// Generate a token.
  $url = $I->generateSustainerUpgradeToken($anon, "1002", 1, 1);

// Go to the upgrade form.
  $I->amOnUrl($url);

// Cancel the upgrade.
  $I->click('Click here');
  $I->canSeeInCurrentUrl("node/2");

// Go to the upgrade form with expired token.
  $I->amOnUrl($url);
  $I->see('An error occurred and we could not complete the operation.');

// Use an invalid User ID.
  $url = $I->generateSustainerUpgradeToken($anon, "1002", 6, 1);
  $I->amOnUrl($url);
  $I->see('An error occurred and we could not complete the operation.');

// Use an invalid donation ID.
  $url = $I->generateSustainerUpgradeToken($anon, "1002", 1, 0);
  $I->amOnUrl($url);
  $I->see('Donation upgrade can not be completed.');

// Use an invalid form id ID.
  $url = $I->generateSustainerUpgradeToken($anon, "1002", 1, 1, 77);
  $I->amOnUrl($url);

  $I->see("Thank you John Tester. (Not John? Click here.) To upgrade your monthly donation to $10.02, click Confirm below.");

// Use a valid form id ID.
  $url = $I->generateSustainerUpgradeToken($anon, "1002", 1, 1, 4);
  $I->amOnUrl($url);
  $I->see("Thank you John Tester. (Not John? Click here.) To upgrade your monthly donation to $10.02, click Confirm below.");

  // Do a rollback.
  $url = $I->generateSustainerUpgradeToken($anon, "1000", 1, 1, NULL, TRUE);
  $I->amOnUrl($url);
  $I->see("Hello John Tester. (Not John? Click here.) To rollback your sustaining donation to $10.00, click Confirm below.");
// Submit.
  $I->click("#edit-submit");
  $I->see("Your donation upgrade has been canceled and rolled back to $10.00.");

}