<?php
// Personal Campaign Creation

$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Configure and test p2p personal campaigns.');

$I->am('admin');
$I->login();

 $admin = new P2pAdminPage($I);
 $admin->enableFeature();

// generate dummy content
$I->amOnPage($admin->starterUrl);
$I->click('Create content');
$I->wait(15);
$I->amOnPage('springboard/p2p');
$I->click('edit','//tr[td//text()[contains(., "Cross River Gorilla")]]');
$node_id = $I->grabFromCurrentUrl('~.*/node/(\d+)/.*~');
$campaign_description = $I->grabValueFrom($admin->body);

$I->click('//a[@href="#node_p2p_campaign_form_group_p2p_images"]');
$I->wait(4);
$campaign_video = $I->grabValueFrom($admin->video);
$I->checkOption($admin->catImageEdit);
$I->checkOption($admin->videoEdit);

$I->click('Personal campaign introduction');
$campaign_intro = $I->grabValueFrom($admin->persIntro);
$I->checkOption($admin->persIntroEdit);
$I->click('#edit-submit');

// add permssions for campaigner and create campaign user
$rid = $I->getRid('Springboard P2P campaigner');
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
// confirm campaign select box is hidden
$I->amOnPage('node/add/p2p-personal-campaign?p2p_cid=' . $node_id);
$I->seeElement('//input[@value="Cross River Gorilla"]');
$I->cantSeeElement('//select');

// add & remove images


//  confirm campaign select box does not appear after ajax event. ???????????
// confirm campaign url is empty ?????????????


// confirm video embed field contains value from parent campaign.
// confirm campaign intro is displayed as a textarea with the default campaign intro from the parent campaign set as the default value.
// confirm images are prefilled with values from the parent campaig
$I->seeElement('//input[@value="' . $campaign_video .'"]');
$I->seeElement('//textarea[text()="' . $campaign_intro .'"]');
$I->seeElement('//table[@id="edit-field-p2p-campaign-images-und-table"]//img[contains(@src, ".png")]');

// save personal campaign node, confirm personal campaign saves with no errors.
$string = time();
$I->fillField('//input[@name="field_p2p_personal_campaign_url[und][0][value]"]', $string);
$I->wait(4);

$I->fillField('//input[@name="field_p2p_personal_campaign_goal[und][0][value]"]', '123');
//force javascript validation on url field
$I->click('body');
$I->wait(2);

$I->click('#edit-submit');
$I->seeElement('.pane-campaign-header img');
$I->seeElement('iframe');

// Edit new personal campaign node, confirm all settings saved.
// Resave, confirm no errors, if possible confirm no duplicate entry in {url_alias}
$I->click('Edit');
$I->wait(4);
$I->seeElement('//input[@value="' . $string . '"]');
$I->seeElement('//input[@value="123.00"]');
$I->click('#edit-submit');
$I->see('has been updated');


// Create personal campaign "missing campaign id"
// visit node/add/p2p-personal-campaign (no campaign id in url)
$I->amOnPage('node/add/p2p-personal-campaign');
// confirm no error messages
$I->cantSeeElement('.error');
$I->click('#edit-submit');
$I->see('Campaign Name field is required.', '.error');
$I->see('Campaign Introduction field is required.', '.error');
$I->see('Campaign field is required.', '.error');
$I->see('Fundraising Goal field is required.', '.error');
$I->see('Campaign URL field is required.', '.error');

// confirm no fields are prepopulated
$I->seeElement('//input[@name="title" and @value=""]');
$I->seeElement('//input[@name="field_p2p_personal_campaign_url[und][0][value]" and @value=""]');

// confirm campaign select is displayed as a select box, is required, and has no prefilled value
$I->seeOptionIsSelected('//select', '- Select a value -');
$I->selectOption('//select', 'Cross River Gorilla');
$I->wait(5);
// confirm selecting campaign redirects to node add form
// confirm campaign id is in the url after redirect
// confirm campaign name, campaign introduction, images, and video embed are prepopulated correctly.
$I->seeInCurrentURl('p2p_cid');
$I->seeElement('//input[@value="Cross River Gorilla"]');
$I->seeElement('//input[@value="' . $campaign_video .'"]');
$I->seeElement('//textarea[text()="' . $campaign_intro .'"]');
$I->seeElement('//table[@id="edit-field-p2p-campaign-images-und-table"]//img[contains(@src, ".png")]');

// Create personal campaign "campaign id invalid"
// visit node/add/p2p-personal-campaign?campaign=<invalid node id> with invalid (numeric) node id
// confirm no error messages
// confirm no fields are prepopulated
// confirm campaign select is displayed as a select box, is required, and has no prefilled value
// visit node/add/p2p-personal-campaign?campaign=<invalid node id> with invalid (non-numeric) node id
// confirm no error messages
// confirm no fields are prepopulated
// confirm campaign select is displayed as a select box, is required, and has no prefilled value

$I->amOnPage('node/add/p2p-personal-campaign/?p2p_cid=1234567');
$I->cantSeeElement('.error');
$I->click('#edit-submit');
$I->see('Campaign Name field is required.', '.error');
$I->see('Campaign Introduction field is required.', '.error');
$I->see('Campaign field is required.', '.error');
$I->see('Fundraising Goal field is required.', '.error');
$I->see('Campaign URL field is required.', '.error');
$I->seeOptionIsSelected('//select', '- Select a value -');

$I->amOnPage('node/add/p2p-personal-campaign/?p2p_cid=wooblewooble');
$I->cantSeeElement('.error');
$I->click('#edit-submit');
$I->see('Campaign Name field is required.', '.error');
$I->see('Campaign Introduction field is required.', '.error');
$I->see('Campaign field is required.', '.error');
$I->see('Fundraising Goal field is required.', '.error');
$I->see('Campaign URL field is required.', '.error');
$I->seeOptionIsSelected('//select', '- Select a value -');

// Create personal campaign "campaign is private, user authorized"
// Create campaign, check "Personal campaigns require approval"
$I->logout();
$I->wait(4);
$I->login();
$I->amOnPage($admin->addCampUrl);
$I->fillField($admin->title, 'Private Campaign');
$I->selectOption($admin->catSelect, "Animal Rights");
$I->wait(5); //load up
$I->fillField($admin->body, 'A private campaign description.');
$I->checkOption($admin->campP2pDonation);
$I->fillField($admin->campP2pDonationGoal, '123');
$I->click('Personal campaign defaults');
$I->checkOption($admin->campApproval);
$I->fillField($admin->orgIntro, 'A private campaign organization intro');
$I->fillField($admin->campExpire, 'A private campaign expiration message');
$I->click('//a[@href="#node_p2p_campaign_form_group_p2p_images"]');
$I->attachFile($admin->slider, '1170x360.png');
$I->attachFile($admin->banner, '1170x360.png');
$I->attachFile($admin->campThumb, '400x240.png');
$I->click('//input[@value="Save"]');
$I->click('Edit');
$node_id = $I->grabFromCurrentUrl('~.*/springboard/node/(\d+)/.*~');
$I->logout();
$I->wait(4);
$I->login('Campaigner', 'Campaigner');
$I->amOnPage('node/' . $node_id);
$I->click('Get Started');
$I->logout();
$I->wait(4);
$I->login();
$I->amOnPage('springboard/p2p');
$I->click('//input[@value="Approve"]','//tr[//td//a//text()[contains(., "campaigner@example.com")]]');
$I->logout();
$I->wait(4);

// Log in as a user authorized for this campaign
// view node/add/p2p-personal-campaign?p2p_cid=<node id> with the node id of the campaign
// confirm node add form is populated with defaults from the campaign.
// save personal campaign
// confirm settings saved with no errors.
$I->login('Campaigner', 'Campaigner');
$I->amOnPage('node/add/p2p-personal-campaign?p2p_cid=' . $node_id);
$I->seeInCurrentURl('p2p_cid');
$I->seeElement('//input[@value="Private Campaign"]');


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
