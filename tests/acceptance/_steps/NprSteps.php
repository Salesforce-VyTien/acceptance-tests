<?php
namespace AcceptanceTester;

class NprSteps extends \AcceptanceTester\SpringboardSteps {
  /**
   * @return array
   *   Form IDs.
   */
  public function donationFormIds() {
    // Navigate through ajax pager collecting IDs of all forms.
    $form_ids = array();
    $I = $this;
    $I->amOnPage('springboard/donation-forms/donation_form');
    do {
      $form_ids = array_merge($form_ids, $I->grabMultiple('tbody .views-field-nid'));
    } while ($this->gotoNextPage());

    return $form_ids;
  }

  /**
   * Go to the next page of an ajax pager.
   *
   * @return bool
   *   Whether navigation happened.
   */
  private function gotoNextPage() {
    $I = $this;
    // Test for 'next' link in pager.
    $next_text = $I->executeJS('return jQuery(".pager-next").text()');
    if ($next_text) {
      $current_text = $I->executeJS('return jQuery(".pager-current").text()');
      $I->click($next_text);
      $I->waitForJS('return jQuery(".pager-current").text() != ' . $current_text);
      return TRUE;
    }
    return FALSE;
  }

  public function configureDonationForm($nid) {
    $I = $this;
    $I->amOnPage("springboard/node/$nid/edit");
    // Payment Methods is the 2nd vertical tab.
    $I->click('.vertical-tab-button:nth-child(2) a');
    $I->selectOption('#edit-gateways-credit-id', 'Test Gateway');
    $I->selectOption('#edit-gateways-bank-account-id', 'NPR Sage EFT');
    $I->click('Save');

    // Confirm things saved.
    $I->amOnPage("springboard/node/$nid/edit");
    $I->click('.vertical-tab-button:nth-child(2) a');
    $I->seeOptionIsSelected('#edit-gateways-credit-id', 'Test Gateway');
    $I->seeOptionIsSelected('#edit-gateways-bank-account-id', 'NPR Sage EFT');
  }
}
