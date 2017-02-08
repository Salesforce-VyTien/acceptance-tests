<?php
// @group npr
$I = new \AcceptanceTester\NprSteps($scenario);
$I->wantTo('Disable the "Sustainers failed health checks" rule that sends an email.');
$I->am('admin');
$I->login();

$I->amOnPage('/admin/config/workflow/rules/reaction/manage/rules_sustainers_check_failure');
$I->click('Settings');
//$I->waitForText('Active');
$I->waitForElementVisible('#edit-settings-active');
$I->uncheckOption('#edit-settings-active');
$I->click('Save changes');
$I->see('Your changes have been saved', '.status');
