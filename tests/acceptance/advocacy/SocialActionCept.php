<?php
//$scenario->skip();

$scenario->group('no_populate');
// Acceptance tests for admin UI and menus.
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Configure Social Actions');

$I->am('admin');
$I->login();
$I->enableModule('Springboard Advocacy');
$advocacy = new advocacyPage($I);
$advocacy->configureAdvocacy();
////

$I->enableModule('form#system-modules input#edit-modules-springboard-advocacy-sba-social-action-enable');

$I->amOnPage(\AdvocacyPage::$settingsPage);
// submit to get an access token
$I->click('#edit-submit');

$I->amOnPage(NodeAddPage::route('sba-social-action'));
$I->fillField(\NodeAddPage::$title, "Test action");
$I->fillField(\NodeAddPage::$internalTitle, "Test Action");
$I->fillField('#edit-body-und-0-value', "Test Action");

$I->click(\NodeAddPage::$save);
$I->click('Messages');

$I->click('.sba-add-button');
$I->fillField('#edit-name', "Test Message");
$I->fillField('#edit-field-sba-twitter-message-und-0-value', "Test Tweet");
$I->click('#edit-field-sba-twitter-message-und-add-more');
$I->wait(3);

$I->fillField('.ajax-new-content textarea', "Test Tweet 2");
$I->see('You have used 10 characters in your message. You currently have a maximum of 140 characters for this message.');
$I->checkOption('#edit-field-sba-prepend-target-name-und');
$I->see('You have used 10 characters in your message. You currently have a maximum of 139 characters for this message.');
$I->checkOption('//input[@name="field_sba_target_options[und]"]');
$I->checkOption('//input[@name="search_role_1[FS]"]');
$I->click('#quick-target');
$I->wait(1);
$I->see("Federal Senators");
$I->click('#edit-submit');
$I->wait(3);


//$I->amOnPage('node/5');

$I->click('View');
$I->fillField('First name', "John");
$I->fillField('Last name', "Doe");
$I->fillField('Address', "1100 Broadway");
$I->fillField('City', "Schenectady");
$I->fillField('Zip Code', "12345");
$I->selectOption('State', 'New York');
$I->click('#edit-submit');
$I->waitForElement("#edit-twitter-sign-in", 10);
$I->click('#edit-twitter-sign-in');
$I->see("Kirsten Gillibrand");

$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
  $handles=$webdriver->getWindowHandles();
  $last_window = end($handles);
  $webdriver->switchTo()->window($last_window);
});

$I->see("Springboard Social");
$I->switchToWindow();
$I->click("I'm done");
$I->see('Thank you for participating in the messaging campaign');
