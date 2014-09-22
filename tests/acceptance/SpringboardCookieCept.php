<?php
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('make anonymous social shares, reveal my identity to Springboard, and have my anonymous shares sync to my Contact.');

/**
 * Configure Springboard Social and Springboard Cookie.
 */
$I->am('admin');
$I->login();

// Make sure Springboard Social, Springboard Cookie, and Token Filter are enabled
//$I->enableModule('Springboard Social');
//$I->enableModule('Springboard Cookie');
//$I->enableModule('Token Filter');
$I->amOnPage(ModulesPage::$URL);
$I->checkOption('#edit-modules-other-token-filter-enable');
$I->click(ModulesPage::$submitButton);

// Enable tokens on Filtered HTML input.
$I->amOnPage('/admin/config/content/formats/filtered_html');
$I->checkOption('#edit-filters-filter-tokens-status');
$I->click('#edit-actions-submit');

//@TODO: additional configuration from the test plan, incl. AddThis -- or maybe use the Db module?

/**
 * Configure a petition page with social share links.
 */
$I->amOnPage(NodeAddWebformPage::$URL);
$I->fillField(NodeAddWebformPage::$titleField, 'Test Petition');
$I->fillField(NodeAddWebformPage::$internalNameField, 'Test Springboard Cookie: Petition');
$I->click(NodeAddWebformPage::$pathSettingsTab);
$I->fillField(NodeAddWebformPage::$URLAliasField, 'test/cookie/petition');
$I->click(NodeAddWebformPage::$saveButton);
// Save should redirect us to the webform components edit page.
$I->seeCurrentUrlMatches('~/node/(\d+)/webform/components~');
$nid = $I->grabFromCurrentUrl('~/node/(\d+)/webform/components~');
$I->amOnPage("/node/$nid/webform/configure");
$I->fillField('#edit-confirmation-confirmation-page-title', 'Thank you, now share!');
$I->fillField('#edit-confirmation-value', '[sb_social:share_links]');
$I->click('#edit-submit');

/**
 * Configure a non-interactive node to display social share links.
 */
$I->amOnPage(NodeAddPagePage::$URL);
$I->fillField(NodeAddPagePage::$titleField, 'Test Plain Content');
$I->fillField(NodeAddPagePage::$bodyField, 'Share! [sb_social:share_links]');
$I->click(NodeAddPagePage::$pathSettingsTab);
$I->fillField(NodeAddPagePage::$URLAliasField, 'test/cookie/plain');
$I->click(NodeAddPagePage::$saveButton);

/**
 * Make anonymous shares of the non-interactive node.
 */
$I->resetCookie('Springboard');
$I->logout();
$I->amOnPage('/test/cookie/plain');
$I->waitForElementVisible('.addthis_button_facebook', 30);
//$I->pauseExecution();
$I->click('.addthis_button_facebook');
$I->waitForElementVisible('.addthis_button_twitter', 30);
$I->click('.addthis_button_twitter');

/**
 * TEST: Was the cookie created?
 */
$I->seeCookie('Springboard');
$I->wait(1); //@TODO: better way? waitForJS()?

/**
 * Submit petition with a novel email address.
 */
$I->amOnPage('/test/cookie/petition');
$user_email = 'jr+'.uniqid().'@jacksonriver.com';
$I->fillField('#edit-submitted-mail', $user_email);
$I->click('#edit-submit');

/**
 * TEST: Was a new user created, and were the anonymous shares updated with that user account's UID?
 */
$user_uid = $I->grabFromDatabase('users', 'uid', array('mail' => $user_email));
$I->seeInDatabase('sb_social_shares', array('uid' => $user_uid, 'service' => 'facebook'));
$I->seeInDatabase('sb_social_shares', array('uid' => $user_uid, 'service' => 'twitter'));
$I->logout();
