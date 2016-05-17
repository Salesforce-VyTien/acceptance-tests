<?php
/**
 * Class ticketsCest
 */
class ticketsCest {
  /**
   * @var $nid
   */
  public static $nid;

  public function _construct ($nid) {
    $this->nid = $nid;
  }
  /**
   * @param \AcceptanceTester\SpringboardSteps $I
   */
  public function _before(AcceptanceTester\SpringboardSteps $I) {
    $tickets = new TicketsTabPage($I, $this);
    $tickets->configureTickets();
  }

  /**
   * @param \AcceptanceTester\SpringboardSteps $I
   */
  public function _after(AcceptanceTester\SpringboardSteps $I) {
  }

  /**
   * @param \AcceptanceTester\SpringboardSteps $I
   */
  public function testClosedEvents(AcceptanceTester\SpringboardSteps $I) {
    $I = $this->_closedEvents($I);
    $this->_expiredEvents($I);
  }

  /**
   * @param \AcceptanceTester\SpringboardSteps $I
   */
  public function testSoldOutEvents(AcceptanceTester\SpringboardSteps $I) {
    $this->_soldOutEvents($I);
  }


  /**
   * @param \AcceptanceTester\SpringboardSteps $I
   */
  public function _createContentType(AcceptanceTester\SpringboardSteps $I) {
    $I->wantTo('Create a fundraiser tickets content type.');
    $I->amOnPage(\ContentTypePage::addRoute());
    $I->fillField(\ContentTypePage::$name, 'Ticketed Event');
    $I->click('Fundraiser settings');
    $I->click(\ContentTypePage::$fundraiserTab);
    $I->checkOption(\ContentTypePage::$fundraiser);
    $I->checkOption(\ContentTypePage::$fundraiserTickets);
    $I->click(\ContentTypePage::$webformUserTab);
    $I->checkOption(\ContentTypePage::$webformUser);
    $I->click(\ContentTypePage::$save);
    return $I;
  }

  /**
   * @param \AcceptanceTester\SpringboardSteps $I
   */
  public function _createWaitListForm(AcceptanceTester\SpringboardSteps $I) {
    $I->amOnPage(\NodeAddPage::route('webform'));
    $I->fillField(\NodeAddPage::$title, 'Wait List Form');
    $I->click(\NodeAddPage::$save);
    return $I;
  }

  /**
   * @param \AcceptanceTester\SpringboardSteps $I
   */
  public function _createTicketNode(AcceptanceTester\SpringboardSteps $I) {
    $I->amOnPage(\NodeAddPage::route('ticketed-event'));
    $I->fillField(\NodeAddPage::$title, 'Ticketed Event');
    $I->fillField('#edit-field-fundraiser-internal-name-und-0-value', 'Ticketed Event');
    $I->click("Payment methods");
    $I->checkOption('//input[@name="gateways[credit][status]"]');
    $I->click(\NodeAddPage::$save);
    $this->nid = $I->grabFromCurrentUrl('~.*/node/(\d+)/.*~');
    $I->click('View');
    $I->see('The form will not work properly until tickets have been created. To add tickets, click here.');
    $I->see('Tickets', '.fieldset-legend');
    $I->amOnPage(\TicketsTabPage::route($this->nid));
    $I->see('Wait List options');
    $I->see('Close settings');
    $I->see('Sell out settings');
    $I->see('Donation add-on');
    $I->selectOption(\TicketsTabPage::$waitList, 'Wait List Form');
    $I->click('Save');
    return $I;
  }

  /**
   * @param \AcceptanceTester\SpringboardSteps $I
   */
  public function _createTickets(AcceptanceTester\SpringboardSteps $I) {

    $I->amOnPage(\TicketsTabPage::route($this->nid) . '/tickets');
    $I->click('Add ticket type');
    $I->fillField(ProductsUIPage::$sku, '1111');
    $I->fillField(ProductsUIPage::$title, 'Ticket 1');
    $I->fillField(ProductsUIPage::$price, 10);
    $I->fillField(ProductsUIPage::$description, 'Ticket 1 description.');
    $I->fillField(ProductsUIPage::$threshold, 1);
    $I->fillField(ProductsUIPage::$message, 'A warning message.');
    $I->fillField(ProductsUIPage::$quantity, 2);
    $I->click('Save product');

    $I->amOnPage(\TicketsTabPage::route($this->nid) . '/tickets');
    $I->click('Add ticket type');
    $I->fillField(ProductsUIPage::$sku, '1112');
    $I->fillField(ProductsUIPage::$title, 'Ticket 2');
    $I->fillField(ProductsUIPage::$price, 10);
    $I->fillField(ProductsUIPage::$description, 'Ticket 2 description.');
    $I->fillField(ProductsUIPage::$threshold, 1);
    $I->fillField(ProductsUIPage::$message, 'A warning message.');
    $I->fillField(ProductsUIPage::$quantity, 2);
    $I->click('Save product');
    $I->amOnPage('node/' .  $this->nid);
    $I->see('Ticket 1 description.');
    $I->see('Ticket 1 ($10.00)');
    return $I;
  }

  public function _closedEvents(AcceptanceTester\SpringboardSteps $I) {

    $I->amOnPage(\TicketsTabPage::route($this->nid));
    $I->checkOption(\TicketsTabPage::$closed);
    $I->selectOption(\TicketsTabPage::$closedOptions, 'form');
    $I->click('Save');
    $I->amOnPage('node/' . $this->nid);
    $I->see('This form is closed and users are being redirected to the waitlist form');
    $I->logout();
    $I->amOnPage('node/' . $this->nid);
    $I->see('Wait List Form');

    $I->am('admin');
    $I->login();
    $I->amOnPage(\TicketsTabPage::route($this->nid));
    $I->selectOption(\TicketsTabPage::$closedOptions, 'message');
    $I->waitForElement(\TicketsTabPage::$closedMessage, 5);
    $I->fillField(\TicketsTabPage::$closedMessage, 'This event is closed.');
    $I->click('Save');
    $I->logout();
    $I->amOnPage('node/' . $this->nid);
    $I->see('This event is closed.');

    $I->am('admin');
    $I->login();
    $I->amOnPage(\TicketsTabPage::route($this->nid));
    $I->selectOption(\TicketsTabPage::$closedOptions, 'redirect');
    $I->waitForElement(\TicketsTabPage::$closedRedirect, 5);

    $I->fillField(\TicketsTabPage::$closedRedirect, 'node/2');
    $I->click('Save');
    $I->logout();
    $I->amOnPage('node/' . $this->nid);
    $I->seeInCurrentUrl('node/2');
    return $I;
  }

  public function _expiredEvents(AcceptanceTester\SpringboardSteps $I) {
    $I->am('admin');
    $I->login();
    $I->amOnPage(\TicketsTabPage::route($this->nid));
    $I->unCheckOption(\TicketsTabPage::$closed);
    $I->fillField(\TicketsTabPage::$closedDate, '1/1/2016');
    $I->click('Save');
    $I->logout();
    $I->amOnPage('node/' . $this->nid);
    $I->seeInCurrentUrl('node/2');

    $I->am('admin');
    $I->login();
    $I->amOnPage(\TicketsTabPage::route($this->nid));
    $I->fillField(\TicketsTabPage::$closedDate, '');
    $I->click('Save');
    return $I;
  }

  /**
   * @param \AcceptanceTester\SpringboardSteps $I
   */
  public function _soldOutEvents(AcceptanceTester\SpringboardSteps $I) {
    $I->amOnPage(\TicketsTabPage::route($this->nid));
    $I->selectOption(\TicketsTabPage::$soldOutOptions, 'message');
    $I->fillField(\TicketsTabPage::$soldOutMessage, 'My sold out message');
    $I->click('Save');
    $I->logout();
    $I->amOnPage('node/' . $this->nid);
    $I->fillInMyName();
    $I->fillInMyCreditCard();
    $I->fillInMyAddress();
    $I->fillField(\DonationFormPage::$emailField, 'admin@example.com');
    $I->selectOption(\TicketsTabPage::$ticketOneQuant, 1);
    $I->selectOption(\TicketsTabPage::$ticketTwoQuant, 1);
    $I->see('$20.00');
    $I->see('2', '#fundraiser-tickets-total-quant');
    $I->click('Submit');
    $I->amOnPage('node/' . $this->nid);
    $I->see('*Only 1 ticket remaining!*');
    $I->fillInMyName();
    $I->fillInMyCreditCard();
    $I->fillInMyAddress();
    $I->fillField(\DonationFormPage::$emailField, 'admin@example.com');
    $I->selectOption(\TicketsTabPage::$ticketOneQuant, 1);
    $I->selectOption(\TicketsTabPage::$ticketTwoQuant, 1);
    $I->click('Submit');
    $I->amOnPage('node/' . $this->nid);
    $I->see('My sold out message');
  }

}
