<?php
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('remove the default ask amount.');

$I->am('admin');

$I->login();

$I->cloneADonationForm();
$I->click('No default ask amount');
$I->click('Save');
$I->dontSeeCheckboxIsChecked('#edit-submitted-donation-amount input[type=radio]');

$I->logout();
