<?php

$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Configure and test p2p settings.');

$I->am('admin');
$I->login();

$admin = new P2pAdminPage($I);

$admin->enableFeature();

// User has the ability to set the peer to peer login message
// A list of all fundraiser types and the forms of that type can be enabled for peer to peer fundraising
// User has the ability to choose which configured profile fields display on the registration page, excluding first, last, and email, which are always required.
// User has the ability to sort the order in which the fields appear on the registration page
// User can make non-required profile fields required on the registration page
// Rules
// User can configure an email to an admin when a campaigner is requesting approval to a private campaign
// User can configure an email to the campaigner when requesting approval to a private campaign
// User can configure an email for when a campaigner is approved for a private campaign
// User can configure an email for when a campaigner is rejected for a private campaign
// User can configure an email for when a new campaigner registers on the site
// User can configure an email for when an existing drupal user requests a password reset via the P2P UI.
// Dashboard
// User sees a list of configured peer to peer campaigns
// User has the ability to create a new peer to peer campaign
// User sees a list of configured peer to peer categories
// User has the ability to create a new peer to peer category
// User sees a list of personal campaigners that require approval
// User has the ability to approve or reject a campaigner from the dashboard
// User sees a list of personal campaigns
// Approval Queue
// Approval email is sent to personal campaigner when approved
// Rejection email is sent to personal campaigner when rejected
// Peer to Peer Category Creation
// Only a permissioned user can create campaign categories
// User must provide a name, description and image when creating a new category
// User can upload a donation form banner
// User can provide default content that can be used in campaigns and personal campaigns
// User can set an organization introduction
// User can set a personal campaign introduction
// User can specify if the personal campaigner can override the personal campaign introduction
// User can upload personal campaign images
// User can specify if the personal campaigner can override the images
// User can set a video embed url
// User can specify if the personal campaigner can override the video embed
// Peer to Peer Campaign Creation
// User must select a campaign category
// User must provide a name, description, thumbnail and slider image when creating a new campaign
// User must configure exactly 1 form to use with the campaign and configure an associated goal
// Goal types match the selected form type (amount raised for fundraiser enabled forms, submissions for all others)
// If the selected category has a donation form banner it is pre-populated in the campaign banner field
// If the selected category has an organization introduction it is pre-populated
// If the selected category has a personal campaign introduction it is pre-populated
// The personal campaign introduction's overridable setting is inherited from the selected category
// If the selected category has personal campaign images they are pre-populated
// The personal campaign images' overridable setting is inherited from the selected category
// If the selected category has a video embed it is pre-populated
// The video embed's overridable setting is inherited from the selected category