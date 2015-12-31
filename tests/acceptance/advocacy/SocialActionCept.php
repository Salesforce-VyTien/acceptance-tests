<?php
$scenario->skip();

$scenario->group('no_populate');
// Acceptance tests for admin UI and menus.
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Configure Social Actions');

$advocacy = new advocacyPage($I);
$advocacy->configureAdvocacy();
//
$I->am('admin');
$I->login();
//
$I->enableModule('form#system-modules input#edit-modules-springboard-advocacy-sba-social-action-enable');

//
$I->amOnPage(\AdvocacyPage::$settingsPage);
// submit to get an access token
$I->click('#edit-submit');

$I->amOnPage(NodeAddPage::route('social-action'));
//$I->fillField(\NodeAddPage::$title, "Test action");
//$I->fillField(\NodeAddPage::$internalTitle, "Test Action");
//$I->click(\NodeAddPage::$save);