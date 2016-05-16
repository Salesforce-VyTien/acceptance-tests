<?php
$scenario->group('this');
$scenario->group('fundraiser');
$I = new \AcceptanceTester\SpringboardSteps($scenario);


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


$I->amOnPage(\NodeAddPage::route('webform'));
$I->fillField(\NodeAddPage::$title, 'Wait List Form');
$I->click(\NodeAddPage::$save);

$I->amOnPage(\NodeAddPage::route('ticketed-event'));
$I->fillField(\NodeAddPage::$title, 'Ticketed Event');
$I->fillField('#edit-field-fundraiser-internal-name-und-0-value', 'Ticketed Event');
$I->click("Payment methods");
$I->checkOption('//input[@name="gateways[credit][status]"]');
$I->click(\NodeAddPage::$save);
$nid = $I->grabFromCurrentUrl('~.*/node/(\d+)/.*~');

$I->click('View');
$I->see('The form will not work properly until tickets have been created. To add tickets, click here.');
$I->see('Tickets', '.fieldset-legend');

$I->amOnPage(\TicketsTabPage::route($nid));

$I->see('Wait List options');
$I->see('Close settings');
$I->see('Sell out settings');
$I->see('Donation add-on');
$I->selectOption(\TicketsTabPage::$waitList, 'Wait List Form');
$I->checkOption(\TicketsTabPage::$closed);
$I->selectOption(\TicketsTabPage::$closedOptions, 'form');
$I->click('Save');

$I->amOnPage(\TicketsTabPage::route($nid) . '/tickets');
$I->click('Add ticket type');
$I->fillField(ProductsUIPage::$sku, '1111');
$I->fillField(ProductsUIPage::$title, 'Ticket 1');
$I->fillField(ProductsUIPage::$price, 10);
$I->fillField(ProductsUIPage::$description, 'Ticket 1 description.');
$I->fillField(ProductsUIPage::$threshold, 1);
$I->fillField(ProductsUIPage::$message, 'A warning message.');
$I->fillField(ProductsUIPage::$quantity, 2);
$I->click('Save product');

$I->amOnPage(\TicketsTabPage::route($nid) . '/tickets');
$I->click('Add ticket type');
$I->fillField(ProductsUIPage::$sku, '1112');
$I->fillField(ProductsUIPage::$title, 'Ticket 2');
$I->fillField(ProductsUIPage::$price, 10);
$I->fillField(ProductsUIPage::$description, 'Ticket 2 description.');
$I->fillField(ProductsUIPage::$threshold, 1);
$I->fillField(ProductsUIPage::$message, 'A warning message.');
$I->fillField(ProductsUIPage::$quantity, 2);
$I->click('Save product');

$I->amOnPage('node/' . $nid);
$I->see('This form is closed and users are being redirected to the waitlist form');
$I->logout();
$I->amOnPage('node/' . $nid);
$I->see('Wait List Form');


$I->am('admin');
$I->login();
$I->amOnPage(\TicketsTabPage::route($nid));
$I->selectOption(\TicketsTabPage::$closedOptions, 'message');
$I->waitForElement(\TicketsTabPage::$closedMessage, 5);
$I->fillField(\TicketsTabPage::$closedMessage, 'This event is closed.');
$I->click('Save');
$I->logout();
$I->amOnPage('node/' . $nid);
$I->see('This event is closed.');


$I->am('admin');
$I->login();
$I->amOnPage(\TicketsTabPage::route($nid));
$I->selectOption(\TicketsTabPage::$closedOptions, 'redirect');
$I->waitForElement(\TicketsTabPage::$closedRedirect, 5);

$I->fillField(\TicketsTabPage::$closedRedirect, 'node/2');
$I->click('Save');
$I->logout();
$I->amOnPage('node/' . $nid);
$I->seeInCurrentUrl('node/2');


$I->am('admin');
$I->login();
$I->amOnPage(\TicketsTabPage::route($nid));
$I->unCheckOption(\TicketsTabPage::$closed);
$I->fillField(\TicketsTabPage::$closedDate, '1/1/2016');
$I->click('Save');
$I->logout();
$I->amOnPage('node/' . $nid);
$I->seeInCurrentUrl('node/2');

$I->am('admin');
$I->login();
$I->amOnPage(\TicketsTabPage::route($nid));
$I->fillField(\TicketsTabPage::$closedDate, '');
$I->click('Save');

//
//$I->seeElement('th', '.ticket_type');
