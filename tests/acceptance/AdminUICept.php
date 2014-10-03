<?php

// Acceptance tests for admin UI and menus.
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('use the Springboard Admin UI to manage my settings and content');

// Create a user with the Springboard Administrator role.
$I->am('admin');
$I->wantTo('login and create a user with the Springboard Administrator role.');
$I->login();
$rid = $I->getRid('Springboard administrator');
$I->createUser('john', 'john@example.com', $rid);
$I->logout();

$I->am('user with the Springboard Administrator role');
$I->login('john', 'john');

$I->seeInCurrentUrl('/springboard');
$I->see('Administration', '.page-title');
$I->cantSeeElement('.error');

// Main menu checks.
$I->see('Donation Forms', 'a.dropdown-toggle');
$I->see('Forms', 'a.dropdown-toggle');
$I->see('Asset Library', 'a.dropdown-toggle');
$I->see('Marketing & Analytics', 'a.dropdown-toggle');
$I->see('Reports', 'a.dropdown-toggle');

$I->see('Recent donation forms', 'h2');
$I->see('Create donation form', '.add-button');
$I->see('View All Donation Forms', '.more-button');

$I->see('Recent Forms', 'h2');
$I->see('Create form', '.add-button');
$I->see('View All Forms', '.more-button');

$I->see('Sync Status', 'h2');
$I->see('Springboard Version:', '.sb-version-info');

$I->see('Springboard Notes', 'h2');

// Problems start here.
$I->click('Donation Forms');
$I->seeInCurrentUrl('/springboard/donation-forms/all');
$I->see('Donation Forms', '.page-title');

/*
$I->click('Donation Forms');
$I->seeInCurrentUrl('/springboard/donation-forms/all');


//$I->cantSeeElement('.error');
//$I->see('Donation Forms', '.page-title');
//$I->see('Donation Form', 'h2');
$I->see('Create Donation Form', '.add-button');
$I->see('View All Donation Forms', '.more-button');
$I->see('Options', '.button');
$I->see('Internal Name', 'th');
*/
