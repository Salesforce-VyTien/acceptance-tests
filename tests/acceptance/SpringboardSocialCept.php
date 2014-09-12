<?php
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Enable Springboard Social on a donation form.');

// @todo Test BCC

// Form defaults
$facebook_title = 'Acceptance testing in Facebook is rad.';
$facebook_description = 'Seriously, Facebook Acceptance testing is the best thing ever.';
$facebook_image = '';

$twitter_message = 'Acceptance testing in Twitter is rad.';


$email_subject = 'Acceptance testing email subject.';
$email_message = 'Acceptance testing email message.';

// Log in an admin account.
$I->am('admin');
$I->login();
$admin = new SpringboardSocialAdminPage($I);
$shorten = new ShortenURLsAdminPage($I);
$marketsource = new MarketSourceAdminPage($I);

// Enable Springboard Social;
$admin->enableModule();

// Configure defaults
$admin->setAdminDefaults();

// Enable Share block.
$admin->enableBlock();

// Config Shorten URLS
$shorten->setAdminDefaults();

// Configure Market Source integration
// TODO: fix css on Social enable checkboxes so Selenium can check them.

$I->amOnPage($marketsource->URL);
// enable MS and CID global default fields
$marketsource->showDefaultFieldSettings();
$I->checkOption('#edit-market-source-default-fields-default-fields-wrapper-market-source-share-enabled');
$I->checkOption('#edit-market-source-default-fields-default-fields-wrapper-campaign-share-enabled');

// Create custom field & enable with Social
$marketsource->createCustomField('UTM Medium', 'utm_medium', 'utm_social_test');
$I->checkOption('#edit-market-source-global-fields-custom-fields-wrapper-0-share-enabled');
$I->click('#edit-submit');

// ### END BASE CONFIG ###


// Configure node-level settings on donation form.
$I->amOnPage('/node/2/share_settings');
// Save defaults
// TODO: set default values for enabled Market Source fields.

$I->click('#edit-submit');

// confirm share display in block
$I->amOnPage('/node/2');
$I->see('Share on Facebook!');
$I->see('Share with Email!');
$I->see('Share on Twitter!');

// Configure confirmation message
$I->amOnPage('node/2/form-components/confirmation-page-settings');
// TODO: add all Social Share tokens.
$I->fillField('#edit-confirmation-value', 'Thank you for your donation. Share links: [sb_social:share_links]');
$I->click('#edit-submit');

// Submit donation form,
// confirm share tokens replace in confirmation message
// confirm share urls generated correctly

$I->logout();
