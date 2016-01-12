<?php
$scenario->skip();

$scenario->group('no_populate');
// Acceptance tests for admin UI and menus.
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Configure Social Actions');

$I->am('admin');
$I->login();
$I->enableModule('Springboard Advocacy');
$advocacy = new advocacyPage($I);
$advocacy->configureAdvocacy();
$I->enableModule('form#system-modules input#edit-modules-springboard-advocacy-sba-social-action-enable');
$I->amOnPage(\AdvocacyPage::$settingsPage);
// Submit to get an access token.
$I->click('#edit-submit');

// Add a social action.
$I->amOnPage(NodeAddPage::route('sba-social-action'));
$I->fillField(\NodeAddPage::$title, "Test action");
$I->fillField(\NodeAddPage::$internalTitle, "Test Action");
$I->fillField('#edit-field-sba-social-call-to-action-und-0-value', 'Call to action, yo');
$I->fillField('#edit-body-und-0-value', "Test Action");
$I->fillField('#edit-field-sba-social-step-two-header-und-0-value', 'Step two intro');
$I->fillField('#edit-field-sba-social-step-two-submit-und-0-value', 'I am finished');
$I->selectOption('#edit-field-sba-legislative-issues-und-1', 1);
$I->click(\NodeAddPage::$save);

//Create a districted message.
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
$I->checkOption('#edit-field-sba-show-additional-und-website','website');
$I->checkOption('#edit-field-sba-show-additional-und-youtube','youtube');
$I->checkOption('#edit-field-sba-show-additional-und-facebook','facebook');
$I->checkOption('//input[@name="field_sba_target_options[und]"]');
$I->checkOption('//input[@name="search_role_1[FS]"]');
$I->click('#quick-target');
$I->wait(1);
$I->see("Federal Senators");
$I->click('#edit-submit');
$I->wait(3);

//Create an undistricted message
$I->click('.sba-add-button');
$I->fillField('#edit-name', "Undistricted Test Message");
$I->fillField('#edit-field-sba-twitter-message-und-0-value', "Test Tweet Two");
$I->see('You have used 14 characters in your message. You currently have a maximum of 140 characters for this message.');
$I->checkOption('#edit-field-sba-prepend-target-name-und');


$I->see('You have used 14 characters in your message. You currently have a maximum of 139 characters for this message.');
$I->checkOption('#edit-field-sba-show-additional-und-website','website');
$I->checkOption('#edit-field-sba-show-additional-und-youtube','youtube');
$I->checkOption('#edit-field-sba-show-additional-und-facebook','facebook');

$I->checkOption('//input[@name="search_role_1[FR]"]');
$I->dontSeeElement('#quick-target');

$I->click('Search');
$I->waitForElement('.views-table', 15);
$I->seeElement("table tr.views-row-first");
$I->click('table tr.views-row-first a.advocacy-add-target');
$I->waitForElement('.sba-target-status', 10);
$I->wait(5);
$I->see('This message currently has 1 eligible targets. The allowed maximum is 5.');
$I->click('#edit-submit');
$I->wait(3);


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
$I->wait(60);
$I->see("Kirsten Gillibrand");
$I->see('Step two intro');
$I->see('Test Tweet Two');
$I->see('If you prefer, please contact');
$I->seeNumberOfElements('.message-preview-message-container', 3);
$I->seeNumberOfElements('.uneditable-message-preview', 3);
$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
  $handles=$webdriver->getWindowHandles();
  $last_window = end($handles);
  $webdriver->switchTo()->window($last_window);
});

$I->see("Springboard Social");
$advocacy->twitterLogin();
$I->switchToWindow();
$I->waitForElement('.twitter-asset', 20);
$I->click('Customize and send this tweet');
$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
  $handles=$webdriver->getWindowHandles();
  $last_window = end($handles);
  $webdriver->switchTo()->window($last_window);
});
$I->see('What’s happening?');
$I->switchToWindow();
$I->click("I am finished");
$I->see('Thank you for participating in the messaging campaign');
