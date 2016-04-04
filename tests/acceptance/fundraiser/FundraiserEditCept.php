<?php
$scenario->group('fundraiser');

$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Test fundraiser edit page payment options.');

$title = 'fundraiser node edit test ' . time();

$I->am('admin');
$I->login();
$I->configureEncrypt();
//check server-side validation of payment method selection
$I->amOnPage(DonationFormPage::route('/edit'));

//Go to new Payment methods tab
$I->executeJS('jQuery(".vertical-tabs-list li a").eq(1).click()');
//$I->executeJS('jQuery("#springboard-admin-home-link").remove()');
//$I->click(['xpath' => "//*[@id='donation-form-node-form']/div[5]/ul/li[2]/a"]);
//$I->click('Payment methods');
//$I->click(['xpath' => "//strong[contains(.,'Payment methods')]"]);

#$I->click(['xpath' => "//strong[contains(.,'Display settings')]"]);
//$I->click('Payment methods');

$I->see('Enable donation form payment methods and their corresponding gateways');
$I->executeJS('jQuery("#edit-gateways-credit-status").prop( "checked", false )');

#$I->uncheckOption('#edit-gateways-credit-status');
$I->click('#edit-submit');
$I->see('At least one payment method must be enabled.');

// select credit card method
#$I->checkOption('#edit-gateways-credit-status');
$I->executeJS('jQuery(".vertical-tabs-list li a").eq(1).click()');
$I->executeJS('jQuery("#edit-gateways-credit-status").prop( "checked", true )');
//save and view webform
$I->click('#edit-submit');


$I->amOnPage(DonationFormPage::route('/edit'));
$I->executeJS('jQuery(".vertical-tabs-list li a").eq(1).click()');
$I->executeJS('jQuery("#edit-gateways-credit-status").prop( "checked", false )');
//$I->uncheckOption('#edit-amount-wrapper-show-other-amount');
$I->click('#edit-submit');
$I->dontSeeElement('#edit-submitted-donation-other-amount');

$I->amOnPage(DonationFormPage::route('/edit'));
// $I->checkOption('Show other amount option');
$I->executeJS('jQuery(".vertical-tabs-list li a").eq(1).click()');
$I->executeJS('jQuery("#edit-gateways-credit-status").prop( "checked", true )');
$I->wait(10);
$I->click('#edit-submit');
$I->seeElement('#edit-submitted-donation-other-amount'); //STOPPED


$I->amOnPage(DonationFormPage::route('/edit'));
$I->fillField('Minimum donation amount', '1');
$I->click('#edit-submit');
$I->see('Minimum payment');

$I->amOnPage(DonationFormPage::route('/edit'));
//$I->uncheckOption('Show other amount option');

$I->executeJS('jQuery("#edit-amount-wrapper-show-other-amount").prop("checked", false)');
$I->click('#edit-submit');
$I->dontSee('Minimum payment');

$I->amOnPage(DonationFormPage::route('/edit'));
$I->fillField('#edit-amount-wrapper-donation-amounts-5-amount', '133');
$I->click('form');

$I->click('#edit-amount-wrapper-donation-amounts-5-label');
$I->wait(3);
$I->seeInField('#edit-amount-wrapper-donation-amounts-5-label','$133');
//BREAK??
$I->uncheckOption('//input[@name="default_amount"]');
$I->checkOption('#edit-default-amount--5');
$I->click('body');

$I->click('#edit-submit');

$I->seeCheckboxIsChecked('//input[@value="133"]');

// $I->amOnPage(DonationFormPage::route('/edit'));
// $I->selectOption('#edit-recurring-setting', 'never');
// $I->click('#edit-submit');
// $I->dontSee('Recurring Payment');
