<?php

//@group donationocd;
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('Enable and test fundraiser one click donations.');
$title = 'fundraiser one click donation test ' . time();
$I->am('admin');
$I->login();
$I->configureEncrypt();
$I->configureExamplePaymentMethod();
$I->enableModule('Fundraiser One Click Donate');
$I->amOnPage(DonationFormPage::route('/edit'));
$I->executeJS('jQuery(".vertical-tabs-list li a").eq(1).click()');
$I->executeJS('jQuery("#edit-ocd").prop( "checked", true )');
$I->click('#edit-submit');
$I->see('Donation Form Test Donation Form has been updated.');
$I->logout();

