<?php

$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('test Market Source');

$title = 'market source test';

$I->am('admin');

$I->login();

$I->cloneADonationForm();

$I->amOnPage('/node/add/webform');
$I->fillField('Title', $title);
$I->click('Save');

$I->see('Market Source');
$I->see('Campaign ID');
$I->see('Referrer');
$I->see('Initial Referrer');
$I->see('Search Engine');
$I->see('Search String');
$I->see('User Agent');

$I->click('View');
$I->click('Submit');
$I->see('Thank you, your submission has been received.');
$I->click('Go back to the form');
$I->click('Results');
$I->click('View', '//*[@id="block-system-main"]/div/table[2]/tbody/tr[1]/td[5]/a');
$I->see('default_ms', '#webform-component-ms');
$I->see('/form-components/components', '#webform-component-referrer');

$I->click($title, '#webform-submission-info-text');

$url = $I->grabFromCurrentUrl();
$url .= '?ms=ms_test&cid=test_cid';

//$nick = $I->haveFriend('nick');
//$nick->does(function(AcceptanceTester $I) {
//    $I->am('anonymous');
//    $I->amOnPage($url);
//    $I->click('Submit');
//});

$scenario->incomplete();

$I->logout();
