<?php
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('remove the default ask amount.');

$I->am('admin');

$I->login();

$I->cloneADonationForm();
$I->checkOption('No default ask amount');
$I->click('Save');

$I->dontSeeCheckboxIsChecked('#edit-submitted-donation-amount-1');
$I->dontSeeCheckboxIsChecked('#edit-submitted-donation-amount-2');
$I->dontSeeCheckboxIsChecked('#edit-submitted-donation-amount-3');
$I->dontSeeCheckboxIsChecked('#edit-submitted-donation-amount-4');
$I->dontSeeCheckboxIsChecked('#edit-submitted-donation-amount-5');

$I->click('Edit');
$I->checkOption('#edit-default-amount--3');
$I->click('Save');
$I->seeCheckboxIsChecked('#edit-submitted-donation-amount-3');

$I->logout();
