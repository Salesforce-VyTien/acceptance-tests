<?php
$scenario->group('fundraiser');
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Test fundraiser date mode');

$title = 'fundraiser offline test ' . time();

$I->am('admin');
$I->login();
$I->configureEncrypt();
$I->enableModule('Fundraiser Date Mode');
$I->amOnPage('admin/people/permissions');
$I->see('Administer Fundraiser date mode');
$I->amOnPage('node/2');
$I->makeADonation(array(), TRUE);

$today = date('j');
if ($today > 26) {
  $today = 26;
}
else {
  $today = $today + 1;
}

$I->amOnPage('admin/config/system/fundraiser/date-mode');
$I->checkOption('#edit-fundraiser-date-mode-set-date-mode');
$I->selectOption('#edit-fundraiser-date-mode-set-dates', $today);
$I->fillField('#edit-fundraiser-date-mode-batch-record-count', 500);
$I->checkOption('#edit-fundraiser-date-mode-skip-on-cron');
$I->selectOption('#edit-fundraiser-date-mode-set-seconds', 22);
$I->wait('4');
$I->click('Save configuration');

$I->amOnPage('springboard/donations/1/recurring');
$new_date = '/' . $today . '/' . date('y');
$I->see($new_date);

$I->amOnPage('admin/config/system/fundraiser/date-mode');
$I->selectOption('#edit-fundraiser-date-mode-set-dates', $today + 1);
$I->click('Save configuration');

$I->amOnPage('springboard/donations/1/recurring');
$new_date = '/' . ($today + 1) . '/' . date('y');
$I->see($new_date);