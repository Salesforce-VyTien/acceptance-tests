<?php
// Personal Campaign Creation

$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Configure and test p2p personal campaigns.');

$I->am('admin');
$I->login();

$admin = new P2pAdminPage($I);
$admin->enableFeature();

//generate dummy content
$I->amOnPage($admin->starterUrl);
$I->click('Create content');
$I->wait(15);
$I->amOnPage('springboard/p2p');
$I->click('Cross River Gorilla');
$node_id = $I->grabFromCurrentUrl('~.*/springboard/node/(\d+)/.*~');


$rid = $I->getRid('Springboard P2P campaigner r');
$I->amOnPage('admin/people/permissions/' . $rid);

$I->checkOption('#edit-' . $rid . '-create-p2p-personal-campaign-content');
$I->checkOption('#edit-' . $rid . '-edit-own-p2p-personal-campaign-content');
$I->click('#edit-submit');  

$I->createUser('Campaigner', 'campaigner@example.com', $rid);
$I->logout();
$I->wait(4);
$I->login('Campaigner', 'Campaigner');

// Create personal campaign "standard case"
// view node/add/p2p-personal-campaign?p2p_cid=<campaign_node_id>
// confirm Campaign Name is prefilled with node title from parent campaign
// confirm campaign url is empty
// confirm campaign select box is hidden
// confirm campaign intro is displayed as a textarea with the default campaign intro from the parent campaign set as the default value.
// confirm images are prefilled with values from the parent campaign
// add & remove images
// confirm campaign select box does not appear after ajax event.
// confirm video embed field contains value from parent campaign.
// save personal campaign node, confirm personal campaign saves with no errors.
// Edit new personal campaign node, confirm all settings saved.
// Resave, confirm no errors, if possible confirm no duplicate entry in {url_alias}


// Create personal campaign "missing campaign id"
// visit node/add/p2p-personal-campaign (no campaign id in url)
// confirm no error messages
// confirm no fields are prepopulated
// confirm campaign select is displayed as a select box, is required, and has no prefilled value
// confirm selecting campaign redirects to node add form
// confirm campaign id is in the url after redirect
// confirm campaign name, campaign introduction, images, and video embed are prepopulated correctly.

// Create personal campaign "campaign id invalid"
// visit node/add/p2p-personal-campaign?campaign=<invalid node id> with invalid (numeric) node id
// confirm no error messages
// confirm no fields are prepopulated
// confirm campaign select is displayed as a select box, is required, and has no prefilled value
// visit node/add/p2p-personal-campaign?campaign=<invalid node id> with invalid (non-numeric) node id
// confirm no error messages
// confirm no fields are prepopulated
// confirm campaign select is displayed as a select box, is required, and has no prefilled value

// Create personal campaign "campaign is private, user authorized"
// Create campaign, check "Personal campaigns require approval"
// Log in as a user authorized for this campaign
// view node/add/p2p-personal-campaign?campaign=<node id> with the node id of the campaign
// confirm node add form is populated with defaults from the campaign.
// save personal campaign
// confirm settings saved with no errors.
// Create personal campaign "campaign is private, user is not authorized"
// Log in as a user that is not authorized for the campaign created in the previous segment.
// view node/add/p2p-personal-campaign?p2p_cid=<node id> with the node id of the campaign
// confirm node add form is replaced with a message explaining the campaign is private.
// confirm link is available to request authorization.
// Edit personal campaign "editable defaults"
// Find or create a personal campaign associated with a campaign with editable default values for intro, images, and video
// Edit this personal campaign
// On edit form confirm UI is available for intro, images, and video
// change settings & save
// confirm no error messages on save & settings save successfully.
// Edit personal campaign "uneditable defaults"
// Find or create a personal campaign associated with a campaign with uneditable default values for intro, images, and video
// edit this personal campaign.
// confirm campaign introduction is visible but disabled
// confirm no UI available for images or video
// Save settings, confirm no error messages & settings save
// Missing campaign defaults
// Create a campaign with no default personal campaign intro, no attached images, and no embedded video, leave these fields uneditable.
// Add a personal campaign for this campaign.
// On the node edit form confirm campaign introduction is editable.
// Confirm images UI is unavailable.
// Confirm embedded video UI is unavailable.
// save personal campaign.
// confirm no error messages & settings saved
// Edit existing campaign with editable defaults
// Find a campaign with personal campaigns associated
// Edit the default personal campaign intro, image settings & embedded video settings
// Save.
// View one or more personal campaigns associated with this campaign
// In each case confirm existing settings were not overwritten by changes to the parent campaign
// Edit existing campaign with uneditable defaults
// On a campaign with personal campaigns associated,
// Edit the default personal campaign intro, image settings & embedded video settings
// Save.
// View one or more personal campaigns associated with this campaign
// In each case confirm existing settings were overwritten by changes to the parent campaign