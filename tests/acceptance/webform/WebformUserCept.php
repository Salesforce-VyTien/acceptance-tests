<?php

// Acceptance tests for webform saleforce integration.
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Configure and test webform user settings.');

$I->am('admin');
$I->login();

// enable webform user for the webform content type
// $I->amOnPage('admin/structure/types/manage/webform');
// $I->see('Webform user settings', '.vertical-tab-button');
// $I->click('Webform user settings');
// $I->checkOption('#edit-webform-user--2');
// $I->click('#edit-submit');

// create a new form node
$I->amOnPage(NodeAddPage::route('webform'));
$I->fillField(NodeAddPage::$title, "Test Webform");
$I->fillField(NodeAddPage::$internalTitle, "Test Webform");
$I->click(\NodeAddPage::$save);

// $I->see('User profile fields have been mapped to webform components');
// $I->see('E-mail address', 'td.first');
// $I->see('First name', 'td.first');
// $I->see('Last name', 'td.first');
// $I->see('Address', 'td.first');
// $I->see('Address Line 2', 'td.first');
// $I->see('City', 'td.first');
// $I->see('State/Province', 'td.first');
// $I->see('Postal Code', 'td.first');
// $I->see('Country', 'td.first');

// CHeck that the field types are correct
// $I->see('Hidden', '//td[text()="Market Source"]/following-sibling::td');
// $I->see('E-mail', '//td[text()="E-mail address"]/following-sibling::td');
// $I->see('Hidden', '//td[text()="Campaign ID"]/following-sibling::td');
// $I->see('Hidden', '//td[text()="Referrer"]/following-sibling::td');
// $I->see('Hidden', '//td[text()="Initial Referrer"]/following-sibling::td');
// $I->see('Hidden', '//td[text()="Search Engine"]/following-sibling::td');
// $I->see('Hidden', '//td[text()="Search String"]/following-sibling::td');
// $I->see('Hidden', '//td[text()="User Agent"]/following-sibling::td');
// $I->see('Textfield', '//td[text()="First name"]/following-sibling::td');
// $I->see('Textfield', '//td[text()="Last name"]/following-sibling::td');
// $I->see('Textfield', '//td[text()="Address"]/following-sibling::td');
// $I->see('Textfield', '//td[text()="Address Line 2"]/following-sibling::td');
// $I->see('Textfield', '//td[text()="City"]/following-sibling::td');
// $I->see('Select options', '//td[text()="State/Province"]/following-sibling::td');
// $I->see('Textfield', '//td[text()="Postal Code"]/following-sibling::td');
// $I->see('Select options', '//td[text()="Country"]/following-sibling::td');
// $I->seeCheckboxIsChecked('//td[text()="E-mail address"]/following-sibling::td//input');

// get the new node's id
$node_id = $I->grabFromCurrentUrl('~.*/springboard/node/(\d+)/.*~');

// check that the fields are mapped correctly
// $I->amOnPage('node/' . $node_id . '/webform/user_mapping');
// $I->seeOptionIsSelected('//td[text()="E-mail address"]/following-sibling::td//select', 'E-mail address');
// $I->seeOptionIsSelected('//td[text()="Market Source"]/following-sibling::td//select', 'Market Source');
// $I->seeOptionIsSelected('//td[text()="Campaign ID"]/following-sibling::td//select', 'Campaign ID');
// $I->seeOptionIsSelected('//td[text()="Referrer"]/following-sibling::td//select', 'Referrer');
// $I->seeOptionIsSelected('//td[text()="Initial Referrer"]/following-sibling::td//select', 'Initial Referrer');
// $I->seeOptionIsSelected('//td[text()="Search Engine"]/following-sibling::td//select', 'Search Engine');
// $I->seeOptionIsSelected('//td[text()="Search String"]/following-sibling::td//select', 'Search String');
// $I->seeOptionIsSelected('//td[text()="User Agent"]/following-sibling::td//select', 'User Agent');
// $I->seeOptionIsSelected('//td[text()="First name"]/following-sibling::td//select', 'First name');
// $I->seeOptionIsSelected('//td[text()="Last name"]/following-sibling::td//select', 'Last name');
// $I->seeOptionIsSelected('//td[text()="Address"]/following-sibling::td//select', 'Address');
// $I->seeOptionIsSelected('//td[text()="Address Line 2"]/following-sibling::td//select', 'Address Line 2');
// $I->seeOptionIsSelected('//td[text()="City"]/following-sibling::td//select', 'City');
// $I->seeOptionIsSelected('//td[text()="State/Province"]/following-sibling::td//select', 'State/Province');
// $I->seeOptionIsSelected('//td[text()="Postal Code"]/following-sibling::td//select', 'Postal Code');
// $I->seeOptionIsSelected('//td[text()="Country"]/following-sibling::td//select', 'Country');


/**
 * Testpad: profile field drop down contains all configured profile fields;
 * Would have to bootstrap drupal to do that...
 */


// check to see that authenticated user fields are pre-populated

$I->amOnPage('node/' . $node_id);
$I->fillField('E-mail address', 'mail@example.com');
$I->fillField('First name', 'first');
$I->fillField('Last name', 'last');
$I->fillField('Address', 'address');
$I->fillField('City', 'city');
$I->selectOption('Country', 'United States');
$I->selectOption('State/Province ', 'New York');
$I->fillField('Postal Code', '12205');
$I->click('#edit-submit');

$I->amOnPage('node/' . $node_id);

if ($I->grabValueFrom('E-mail address') == '') {
  $I->fail();
}
if ($I->grabValueFrom('Address') == '') {
  $I->fail();
}
if ($I->grabValueFrom('First name') == '') {
  $I->fail();
}
if ($I->grabValueFrom('Last name') == '') {
  $I->fail();
}
if ($I->grabValueFrom('City') == '') {
  $I->fail();
}
if ($I->grabValueFrom('State/Province') == '') {
  $I->fail();
}
if ($I->grabValueFrom('Postal Code') == '') {
  $I->fail();
}
if ($I->grabValueFrom('Country') == '') {
  $I->fail();
}

$I->logout();
$I->amOnPage('node/' . $node_id);

if ($I->grabValueFrom('E-mail address') != '') {
  $I->fail();
}
if ($I->grabValueFrom('Address') != '') {
  $I->fail();
}
if ($I->grabValueFrom('First name') != '') {
  $I->fail();
}
if ($I->grabValueFrom('Last name') != '') {
  $I->fail();
}
if ($I->grabValueFrom('City') != '') {
  $I->fail();
}
if ($I->grabValueFrom('State/Province') != '') {
  $I->fail();
}
if ($I->grabValueFrom('Postal Code') != '') {
  $I->fail();
}
if ($I->grabValueFrom('Country') != '') {
  $I->fail();
}

// new user created and profile fields set when form is submitted with a unique email address
// existing user profile fields updated when form is submitted with a matching email address
// new account email sent when option enabled

// Alter webform components permission grants access to add//edit/clone/delete webform components
// Administer user map permission grants access to user map
// Configure webform settings permission grants access to the "form settings" tab.
// Configure webform emails permission grants access to the "emails" tab and add/edit/delete paths for webform emails.

