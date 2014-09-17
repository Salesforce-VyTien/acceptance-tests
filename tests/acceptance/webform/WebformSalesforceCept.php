<?php

// Acceptance tests for webform saleforce integration.
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Create a generic webform and test salesforce integration.');

$I->am('admin');
$I->login();

// enable webform user for the webform content type
$I->amOnPage('admin/structure/types/manage/webform');
$I->see('Webform user settings', '.vertical-tab-button');
$I->click('Webform user settings');
$I->checkOption('#edit-webform-user--2');
$I->click('#edit-submit');

// create a new form node
$I->amOnPage(NodeAddPage::route('webform'));
$I->fillField(\NodeAddPage::$title, "Test Webform");
$I->fillField(\NodeAddPage::$internalTitle, "Test Webform");
$I->click(\NodeAddPage::$save);

// get the new node's id
$node_id = $I->grabFromCurrentUrl('~.*/springboard/node/(\d+)/.*~');

// check for the salesforce mapping function
$I->amOnPage('node/' . $node_id . '/salesforce');
$I->see('Salesforce Object Mapping', 'span');

// check opportunity object and donation record type
$I->selectOption(SalesforcePage::$objectType, 'Opportunity');
$I->wait(3);
$I->see(SalesforcePage::$objTypeLabel, 'label');
$I->selectOption(SalesforcePage::$recordType, 'Donation');

// check actions object and petition record type
$I->selectOption(SalesforcePage::$objectType, 'Actions');
$I->wait(3);
$I->see(SalesforcePage::$objTypeLabel, 'label');
$I->selectOption(SalesforcePage::$recordType, 'Petition Submission');

// check to see if all the config sections are visible
$I->see(SalesforcePage::$fieldMap,'span');
$I->see(SalesforcePage::$component,'th');
$I->see(SalesforcePage::$nodeProp,'th');
$I->see(SalesforcePage::$subProp,'th');
$I->see(SalesforcePage::$syncOptions,'label');
$I->see('Contact Field','label');

// map a few fields
$I->selectOption(SalesforcePage::$mapMs, 'Market_Source__c');
$I->selectOption(SalesforcePage::$mapNid, 'Drupal_Node_ID__c');
$I->selectOption(SalesforcePage::$mapSid, 'Submission_ID__c');
$I->selectOption(SalesforcePage::$mapContact, 'Contact__c');

// save mapping
$I->click('#edit-submit--2');

// check if fields are still selected after page reload
$I->seeOptionIsSelected(SalesforcePage::$recordType, 'Petition Submission');
$I->seeOptionIsSelected(SalesforcePage::$mapMs, 'Market Source');
$I->seeOptionIsSelected(SalesforcePage::$mapNid, 'Drupal Node ID');
$I->seeOptionIsSelected(SalesforcePage::$mapSid, 'Submission ID');
$I->seeOptionIsSelected(SalesforcePage::$mapContact, 'Contact');

// unmap the node and check to see if fields are no longer selected
$I->click(SalesforcePage::$unmap);
$I->cantSee(SalesforcePage::$fieldMap,'span');
$I->cantSee(SalesforcePage::$component,'th');
$I->cantSee(SalesforcePage::$nodeProp,'th');
$I->cantSee(SalesforcePage::$subProp,'th');
$I->cantSee(SalesforcePage::$syncOptions,'label');

// remap the actions object in preparation for webform submission by anonymous visitor
$I->selectOption(SalesforcePage::$objectType, 'Actions');
$I->wait(3);
$I->see(SalesforcePage::$objTypeLabel, 'label');
$I->selectOption(SalesforcePage::$recordType, 'Petition Submission');
$I->see(SalesforcePage::$fieldMap,'span');
$I->see(SalesforcePage::$component,'th');
$I->see(SalesforcePage::$nodeProp,'th');
$I->see(SalesforcePage::$subProp,'th');
$I->see(SalesforcePage::$syncOptions,'label');
$I->see('Contact Field','label');
$I->selectOption(SalesforcePage::$mapMs, 'Market_Source__c');
$I->selectOption(SalesforcePage::$mapNid, 'Drupal_Node_ID__c');
$I->selectOption(SalesforcePage::$mapSid, 'Submission_ID__c');
$I->selectOption(SalesforcePage::$mapContact, 'Contact__c');
$I->click('#edit-submit');
$I->seeOptionIsSelected('select#salesforce-map-ms', 'Market Source');
$I->seeOptionIsSelected(SalesforcePage::$mapNid, 'Drupal Node ID');
$I->seeOptionIsSelected(SalesforcePage::$mapSid, 'Submission ID');
$I->seeOptionIsSelected(SalesforcePage::$mapContact, 'Contact');

// logout and submit form
$I->logout();
$I->amOnPage('node/' . $node_id);
$I->fillField('E-mail address', 'p@p.ppp');
$I->fillField('First name', 'first');
$I->fillField('Last name', 'last');
$I->fillField('Address', 'address');
$I->fillField('City', 'city');
$I->selectOption('Country', 'United States');
$I->selectOption('State/Province ', 'New York');
$I->fillField('Postal Code', '12205');
$I->click('#edit-submit');

// log in as admin and check salesforce queue
$I->am('admin');
$I->login();

$I->amOnPage(SalesforcePage::$queuePage);
// there should be at least one row containing the submission
$I->seeElement('tr.views-row-first');
// run cron
$I->amOnPage(SalesforcePage::$cronPage);
// check to see if submission successfully processed
$I->amOnPage(SalesforcePage::$queuePage);
$I->cantSee('tr.views-row-first', '#views-form-sbv-sf-queue-page');
$I->amOnPage(SalesforcePage::$batchPage);
$I->canSeeInField('.views-row-first .views-field-failures', 0);

// edit the submission and check to see that it is requeued.
$I->amOnPage('node/' . $node_id . '/salesforce');
$I->checkOption(SalesforcePage::$syncOptionsCheckbox);
$I->amOnPage('springboard/node/90/results');
$I->click(['link' => 'Edit'], '.sticky-table');
$I->fillField('E-mail address', 'p@p.ddd');
$I->click('#edit-submit');
$I->amOnPage(SalesforcePage::$queuePage);
$I->seeElement('tr.views-row-first');

