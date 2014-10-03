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
//$I->cantSeeElement('.error');

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

$I->click('Donation Forms');
$I->seeInCurrentUrl('/springboard/donation-forms/all');
$I->see('Donation Forms', '.page-title');
//$I->cantSeeElement('.error');
$I->see('Donation Forms', '.page-title');
$I->see('Donation Form', 'h2');
$I->see('Create Donation Form', '.add-button');
$I->see('View All Donation Forms', '.more-button');
$I->see('Options', 'button');

// Form view.
$I->see('Internal Name', 'th');
$I->see('Form Name', 'th');
$I->see('Form ID', 'th');
$I->see('Status', 'th');
$I->see('Date Created', 'th');
$I->see('Action', 'th');
$I->see('Clone', 'td');
$I->see('Edit', 'td');
$I->see('View', 'td');

$I->click('View all Donation Forms');
$I->seeInCurrentUrl('/springboard/donation-forms/donation_form');
$I->see('Donation Forms', '.page-title');
$I->see('Internal Name', 'th');
$I->see('Form Name', 'th');
$I->see('Form ID', 'th');
$I->see('Status', 'th');
$I->see('Date Created', 'th');
$I->see('Action', 'th');
$I->see('Clone', 'td');
$I->see('Edit', 'td');
$I->see('View', 'td');
$I->fillField('#edit-combine', 'NORESULT');
$I->click('Go');
$I->waitForElementNotVisible('.views-table', 30);
$I->dontSeeElement('.views-table');
$I->fillField('#edit-combine', 'Test');
$I->click('Go');
$I->waitForElementVisible('.views-table', 30);
$I->see('Test Donation Form', 'td');

$I->moveMouseOver('li.donationforms');
$I->click('Create a Donation Form');
$I->seeInCurrentUrl('/springboard/add/donation-form');
$I->see('Create Donation Form', '.page-title');

$I->moveMouseOver('li.donationforms');
$I->click('Donation Reports');
$I->seeInCurrentUrl('/springboard/reports/donations');
$I->see('Donations', '.page-title');
$I->seeElement('#views-exposed-form-sbv-donations-page');

// Forms menu item.
$I->click('Forms');
$I->seeInCurrentUrl('/springboard/forms/all');
$I->see('Forms', '.page-title');
$I->moveMouseOver('li.forms');
$I->click('View All Forms');
$I->seeInCurrentUrl('/springboard/forms/all');

// Asset Library
$I->click('Asset Library');
$I->seeInCurrentUrl('/springboard/asset-library');
$I->see('Templates', '.page-title');
$I->see('Page Wrapper', 'h2');
$I->see('Create Page Wrapper', 'a');
$I->see('View all Page Wrappers', 'a');
$I->see('Email Wrapper', 'h2');
$I->see('Create Email Wrapper', 'a');
$I->see('View all Email Wrappers', 'a');

$I->moveMouseOver('li.assetlibrary');
$I->click('Email Templates');
$I->seeInCurrentUrl('/springboard/asset-library/email_wrapper');
$I->see('Email Wrappers', '.page-title');
$I->see('Title', 'th');
$I->see('Status', 'th');
$I->see('Date Created', 'th');
$I->see('Action', 'th');
$I->see('View', 'td a');
$I->see('Edit', 'td a');
$I->see('Clone', 'td a');
$I->see('Delete', 'td a');
$I->click('Create email wrapper');
$I->seeInCurrentUrl('/springboard/add/email-wrapper');
$I->see('Create Email Wrapper', '.page-title');

$I->moveMouseOver('li.assetlibrary');
$I->click('Page Wrappers');
$I->seeInCurrentUrl('/springboard/asset-library/page_wrapper');
$I->see('Page Wrappers', '.page-title');
$I->click('Create page wrapper');
$I->seeInCurrentUrl('/springboard/add/page-wrapper');
$I->see('Create Page Wrapper', '.page-title');

$I->click('Marketing & Analytics');
$I->seeInCurrentUrl('/springboard/marketing-analytics');
$I->see('Marketing & Analytics', '.page-title');
$I->see('Source Codes', 'a');
$I->see('Multivariate Testing', 'a');

$I->click('Reports');
$I->seeInCurrentUrl('/springboard/reports');
$I->see('Reports', '.page-title');
$I->see('Donations', 'a');
$I->see('Contacts', 'a');
$I->see('Integration Reports', 'a');
$I->click('Donations');
$I->seeInCurrentUrl('/springboard/reports/donations');

$I->click('Reports');
$I->click('Contacts');
$I->seeInCurrentUrl('/springboard/reports/contacts');
$I->see('Springboard Contacts', '.page-title');
$I->seeElement('#edit-submit-sbv-contacts');

$I->click('Reports');
$I->click('Integration Reports');
$I->seeInCurrentUrl('/springboard/reports/integration-reports');
$I->see('Integration Reports', '.page-title');
$I->see('Batch Log', 'a');
$I->see('Item Log', 'a');
$I->see('Queue', 'a');
