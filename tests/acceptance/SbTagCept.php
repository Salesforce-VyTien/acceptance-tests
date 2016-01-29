<?php

$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Enable and test Springboard Tags');

// We need a unique title so we can pick it from the template list.
$title = 'Form layouts test ' . time();

$I->am('admin');
$I->login();
$I->enableModule('Springboard Tag');
$I->amOnPage('admin/people/permissions');
$I->checkOption('#edit-4-administer-springboard-tags');
$I->amOnPage('springboard/rebuild-sb-menu');
$I->click('Rebuild');
$I->moveMouseOver('.marketinganalytics');
$I->see('Tags');
$I->amOnPage('springboard/springboard-tags');
$I->see('General Datalayer');
$I->click('Edit');
$I->click('Save');
$I->see('Overridden');
$I->click('.ctools-link');
$I->click('Revert');
$I->click('Revert');
$I->dontSee('Overridden');
$I->click('.ctools-link');
$I->click('Enable');
$I->waitForElement('.ctools-export-ui-enabled', 5);
$I->click('.ctools-link');
$I->click('Disable');
$I->wait(2);
$I->dontSeeElement('.ctools-export-ui-enabled');
