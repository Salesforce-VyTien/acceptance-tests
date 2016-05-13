<?php

$scenario->group('fundraiser');
$scenario->skip();
$I = new \AcceptanceTester\SpringboardSteps($scenario);

$I->wantTo('configure ticketed events.');

$I->am('admin');
$I->wantTo('configure ticketed events.');

$I->login();
$I->configureEncrypt();
$I->enableModule('Fundraiser Tickets');

$I->amOnPage(\ContentTypePage::addRoute());

$I->fillField(\ContentTypePage::$name, 'Ticketed Event');
$I->click('Fundraiser settings');
$I->click(\ContentTypePage::$fundraiserTab);
$I->checkOption(\ContentTypePage::$fundraiser);
$I->checkOption(\ContentTypePage::$fundraiserTickets);
$I->click(\ContentTypePage::$webformUserTab);
$I->checkOption(\ContentTypePage::$webformUser);
$I->click(\ContentTypePage::$save);


$I->amOnPage(\NodeAddPage::route('ticketed-event'));
$I->fillField(\NodeAddPage::$title, 'Ticketed Event');
$I->fillField(\NodeAddPage::$internalTitle, 'Ticketed Event');
$I->click("Payment methods");
$I->checkOption('//input[@name="gateways[credit][status]"]');
$I->click(\NodeAddPage::$save);

$I->see('The form will not work properly until tickets have been created. To add tickets, click here.');
$I->see('Tickets', '.fieldset-legend');
$I->click('Tickets', 'li a');
$I->seeElement('th.ticket_type');

$nid = $I->grabFromCurrentUrl('~.*/node/(\d+)/.*~');
$I->amOnPage(\TicketsTabPage::route($nid));

$I->see('Wait List options');
$I->see('Close settings');
$I->see('Sell out settings');
$I->see('Donation add-on');

