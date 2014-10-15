<?php

$I = new \AcceptanceTester\SpringboardSteps($scenario);
$scenario->incomplete();
$I->wantTo('Configure and test p2p settings.');

$I->am('admin');
$I->login();

$admin = new P2pAdminPage($I);
$admin->enableFeature();

// generate dummy content
$I->amOnPage($admin->starterUrl);
$I->click('Create content');
$I->wait(14);


$I->amOnPage('springboard/p2p');
$I->wait(4);

$I->click('edit','//tr[td//text()[contains(., "No to Nets")]]');
$camp_id = $I->grabFromCurrentUrl('~.*/node/(\d+)/.*~');
$goal = $I->grabValueFrom('//input[@name="field_p2p_personal_campaign_goal[und][0][value]"]');
$I->logout();
$I->wait(4);


// Goal Block
// The goal displayed has the correct value and currency formatted
// Goal progress increases correctly after each donation
// Visual progress bar is representative of the actual progress (e.g., 50% complete the bar should filled halfway)
// Deadline date renders when a deadline configured on the personal campaign
// Link to donation form is rendered and passes the correct personal campaign id to the donation form
$I->amOnPage('node/' . $camp_id);

// $ 1,000.00
$pretty_goal = '$ ' . number_format($goal, 2);

$I->see($pretty_goal, '.goal-amount');
$I->click('Donate now');
$I->wait(4);
//$I->makeADonation();
$I->seeInCurrentURl('p2p_pcid=' . $camp_id);

$I->fillInMyName();
$I->fillField(\DonationFormPage::$emailField, 'bob@example.com');
$I->fillInMyAddress();
$I->fillInMyCreditCard();
$I->click(\DonationFormPage::$donateButton);
$I->wait(4);
$I->amOnPage('node/' . $camp_id);
$I->see('10.00 raised to date');
$I->see('Campaign Deadline');


// Share Block
// User is able to share the personal campaign to the configured social networks

// Recent Donors List
// The recent donors list appears when the "Show donor scroll on personal campaign pages" is set on the campaign the personal campaign is associated with
$I->see('Recent donors');

// The most recent donor appears at the top
// The donors name is not rendered if they do not check the "Show my name on the campaign page" when making a donation to the personal campaign
$I->see('Anonymous');

// The amount and dollar formatting are correct for each recent donation
//$I->see('$ 10.00');

// Content
// The campaign banner image configured at the peer to peer campaign appears at the top of the personal campaign page
// The personal campaign introduction comes from the personal campaigner when set to be overridable
// The personal campaign introduction comes from the personal campaigner when set to be overridable
// The personal campaign images come from the personal campaigner when set to be overridable
// The organization introduction content configured at the peer to peer campaign appears on the personal campaign page
//above are redundant to other tests



// All donate buttons point to the form configured on the peer to peer campaign the personal campaign is associated with
// All donate buttons pass the id of the personal campaign to the donation form on the url
$I->seeElement('//div[contains(@class, "pane-progress")]//a[contains(@href, "p2p_pcid=' . $camp_id .'")]');

// Donor Comments
// Donor comments display when the "Show donor comments on personal campaign pages" setting is enabled on the peer to peer campaign the personal campaign is associated with
// The donors name is not rendered in the comments if they leave a comment and do not check the "Show my name on the campaign page" when making a donation to the personal campaign

// Search Block
// Search block contains a link to all personal campaigns
// User can search for personal campaigns by personal campaign title or campaigner name

// Donate
// Donation form displays the same banner image as the personal campaign
// Donation form displays the title of the personal campaign
// Donation form displays the name of the personal campaigner
// Donation form displays the personal campaign goal
// Donation form displays the personal campaign's goal progress
// Comment text box appears on donation form when the allow donor comments setting is enabled on the peer to peer campaign that the personal campaign is associated with
// Goal progress is updated correctly after a successful donation to the personal campaign is made
// The donation confirmation page and email can utilize personal campaign specific tokens
// Personal campaigner user first name
// Personal campaigner user last name
// personal campaign title
// URL for personal campaign page
// URL for personal campaigner donation page (current node)
// Node id of personal campaign page (nid)
// Personal campaign goal
// Personal campaign deadline
// Donation amount (already handled by fundraiser)
