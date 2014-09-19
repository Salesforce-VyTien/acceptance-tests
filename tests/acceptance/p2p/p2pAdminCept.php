<?php

$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Configure and test p2p settings.');

$I->am('admin');
$I->login();

$admin = new P2pAdminPage($I);
$admin->enableFeature();

// User has the ability to set the peer to peer login message
$I->amOnPage('springboard/p2p/settings');
$I->wait(1);
$I->see('P2P Login message', 'label');
$I->fillField('#edit-login-message-area-value', 'My Custom Login Message');
$I->see('P2P Help message', 'label');
$I->fillField('#edit-help-message-area-value', 'My Custom Help Message');
$I->click('#edit-submit');
$I->see('My Custom Login Message', '#edit-login-message-area-value');
$I->see('My Custom Help Message', '#edit-help-message-area-value');

// A list of all fundraiser types and the forms of that type can be enabled for peer to peer fundraising

$I->see('Peer to peer enabled form types', 'legend');
$I->seeElement('#edit-fundraiser-items-donation-form-enabled');
$I->seeElement('#edit-fundraiser-items-p2p-donation-form-enabled');

// User has the ability to choose which configured profile fields display on the registration page, excluding first, last, and email, which are always required.
$I->see('Registration fields', 'legend');
$I->seeElement('#edit-registration-fields-sbp-zip-enabled');
$I->seeElement('#edit-registration-fields-sbp-state-enabled');
$I->seeElement('#edit-registration-fields-sbp-country-enabled');
$I->seeElement('#edit-registration-fields-sbp-address-line-2-enabled');
$I->seeElement('#edit-registration-fields-sbp-address-enabled');
$I->seeElement('#edit-registration-fields-sbp-city-enabled');

// User has the ability to sort the order in which the fields appear on the registration page

$I->dragAndDrop('//table[@id="registration-fields-table"]//tr[contains(@class, "draggable")][1]//a', '//table[@id="registration-fields-table"]//tr[contains(@class, "draggable")][2]//a');

// User can make non-required profile fields required on the registration page

$I->checkOption('#edit-registration-fields-sbp-state-enabled');
$I->checkOption('#edit-registration-fields-sbp-state-required');
$I->click('#edit-submit');
$I->amOnPage('admin/springboard/p2p/starter');
$I->click('Create content');
$I->wait(15);
$I->logout();
$I->amOnPage('p2p/register?p2p_cid=11');
$I->wait(1);
$I->seeElement('.form-item-sbp-state-und .form-required');

// Rules
// User can configure an email to an admin when a campaigner is requesting approval to a private campaign
// User can configure an email to the campaigner when requesting approval to a private campaign
// User can configure an email for when a campaigner is approved for a private campaign
// User can configure an email for when a campaigner is rejected for a private campaign
// User can configure an email for when a new campaigner registers on the site
// User can configure an email for when an existing drupal user requests a password reset via the P2P UI.

$I->login();
$I->amOnPage('springboard/p2p/rules');

$I->see('rules_p2p_admin_email_private_campaign_approval', '.rules-element-content .description');
$I->see('rules_p2p_password_reset_mail', '.rules-element-content .description');
$I->see('rules_p2p_user_email_personal_campaign_creation', '.rules-element-content .description');
$I->see('rules_p2p_user_email_private_campaign_approval_request', '.rules-element-content .description');
$I->see('rules_p2p_user_email_private_campaign_approved', '.rules-element-content .description');
$I->see('rules_p2p_user_email_private_campaign_rejected', '.rules-element-content .description');
$I->see('rules_p2p_user_email_registration', '.rules-element-content .description');
$I->see('rules_p2p_user_email_registration_private_campaign', '.rules-element-content .description');
$I->see('rules_p2p_user_email_registration_public_campaign', '.rules-element-content .description');

$I->click('Send user email after creating a personal campaign');
$I->seeElement('#edit-settings');

// Dashboard
// User sees a list of configured peer to peer campaigns

$I->amOnPage('springboard/p2p');
$I->see('Cross River Gorilla');
// User has the ability to create a new peer to peer campaign
$I->click('Create a new campaign');
$I->see('Create Peer to Peer Campaign', 'H1');
// User sees a list of configured peer to peer categories
$I->amOnPage('springboard/p2p');
$I->see('Runs and Walks');
// User has the ability to create a new peer to peer category
$I->click('Create a new category');
$I->see('Create Peer to Peer Category', 'H1');

// User sees a list of personal campaigners that require approval
$I->amOnPage('springboard/p2p');
$I->see('Users awaiting approval', 'H2');
// User has the ability to approve or reject a campaigner from the dashboard

// User sees a list of personal campaigns
$I->amOnPage('springboard/p2p');
$I->see('Personal campaigns', 'H2');

// Approval Queue
// Approval email is sent to personal campaigner when approved
// Rejection email is sent to personal campaigner when rejected

// Peer to Peer Category Creation
// Only a permissioned user can create campaign categories
$I->amOnPage('admin/people/create');
$rid = $I->grabValueFrom('//label[normalize-space(text())="Springboard administrator"]/preceding-sibling::input');

$I->amOnPage('admin/people/permissions/' . $rid);
$I->checkOption('#edit-' . $rid . '-create-p2p-category-content');
$I->checkOption('#edit-' . $rid . '-create-p2p-campaign-content');
$I->checkOption('#edit-' . $rid . '-create-p2p-campaign-landing-content');
$I->checkOption('#edit-' . $rid . '-create-p2p-personal-campaign-content');
$I->checkOption('#edit-' . $rid . '-edit-any-p2p-category-content');
$I->checkOption('#edit-' . $rid . '-edit-any-p2p-campaign-content');
$I->checkOption('#edit-' . $rid . '-edit-any-p2p-campaign-landing-content');
$I->checkOption('#edit-' . $rid . '-edit-any-p2p-personal-campaign-content');
$I->click('#edit-submit');  
//$I->createUser('testp2p', 'testp2p@example.com', $rid);
$I->logout();
$I->wait(4);
$I->login('testp2p', 'testp2p');

//User must provide a name, description and image when creating a new category
$I->amOnPage('springboard/add/p2p-category');
$I->seeElement('.form-item-title');
$I->seeElement('.form-item-body-und-0-value .required');

$I->fillField('#edit-title', 'My Category Title');
$I->fillField('#edit-body-und-0-value', 'This is a category description');
// User can upload a donation form banner
$I->click('Donation form');
$I->attachFile('#edit-field-p2p-campaign-banner-und-0-upload', '1170x240.png');
$I->click('Upload');

// User can provide default content that can be used in campaigns and personal campaigns
// User can set an organization introduction
$I->click("Advanced");
$I->see('Organization introduction', 'Label');
$I->fillField('#edit-field-p2p-org-intro-und-0-value', 'My organization introduction');

// User can set a personal campaign introduction
$I->click("Personal campaign introduction");
$I->see("Personal campaign introduction", 'label');
$I->fillField('#edit-field-p2p-personal-intro-und-0-value', 'My personal introduction');

// User can specify if the personal campaigner can override the personal campaign introduction
$I->checkOption('#edit-field-p2p-personal-intro-edit-und');
// User can upload personal campaign images
$I->click("Media");
//category
$I->attachFile('#edit-field-p2p-category-image-und-0-upload', '400x240.png');
//thumbnail;
$I->attachFile('#edit-field-p2p-images-und-0-upload', '400x240.png');
// User can specify if the personal campaigner can override the images
$I->checkOption('#edit-field-p2p-images-edit-und');
// User can set a video embed url
$I->fillField('#edit-field-p2p-video-embed-und-0-video-url', 'http://www.youtube.com/watch?v=6MMMN0VZmYw');
// User can specify if the personal campaigner can override the video embed
$I->checkOption('#edit-field-p2p-video-embed-edit-und');
$I->click("#edit-submit");

// Peer to Peer Campaign Creation
$I->amOnPage('springboard/add/p2p-campaign');
$I->click('#edit-submit');
// User must select a campaign category
// User must provide a name, description, thumbnail and slider image when creating a new campaign
// User must configure exactly 1 form to use with the campaign and configure an associated goal
$I->see('Name field is required.', '.error li');
$I->see('Description field is required.', '.error li');
$I->see('Campaign banner field is required.', '.error li');
$I->see('Landing page slider field is required.', '.error li');
$I->see('Campaign thumbnail field is required.', '.error li');
$I->see('Category field is required', '.error li');
$I->see('Category field is required', '.error li');
$I->see('Personal Campaign Expiration Message field is required', '.error li');
$I->see('Select a goal type.', '.error li');

// What?
// Goal types match the selected form type (amount raised for fundraiser enabled forms, submissions for all others)


// If the selected category has a donation form banner it is pre-populated in the campaign banner field
// If the selected category has an organization introduction it is pre-populated
// If the selected category has a personal campaign introduction it is pre-populated
// The personal campaign introduction's overridable setting is inherited from the selected category
// If the selected category has personal campaign images they are pre-populated
// The personal campaign images' overridable setting is inherited from the selected category
// If the selected category has a video embed it is pre-populated
// The video embed's overridable setting is inherited from the selected category
$I->selectOption('//select[@name="field_p2p_category[und]"]', "My Category Title");
$I->wait('5');
$I->click('Personal campaign defaults');
$I->seeElement('//textarea[normalize-space(text())="My organization introduction"]');
$I->click('Personal campaign introduction');
$I->seeElement('//textarea[normalize-space(text())="My personal introduction"]');
$I->seeCheckboxIsChecked('//input[@name="field_p2p_personal_intro_edit[und]"]');
$I->click('Media');
$I->seeCheckboxIsChecked('//input[@name="field_p2p_images_edit[und]"]');
$I->seeElement('.draggable .image-preview img');
$I->seeElement('div.field-name-field-p2p-campaign-banner img');
$I->see('This is a Youtube or Vimeo video URL');

