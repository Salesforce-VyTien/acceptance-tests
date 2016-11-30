<?php
// @group npr
$I = new \AcceptanceTester\NprSteps($scenario);
$I->wantTo('Configure all donation forms with safe values.');
$I->am('admin');
$I->login();

$ids = $I->donationFormIds();
codecept_debug($ids);

foreach ($ids as $id) {
  $I->configureDonationForm($id);
}
