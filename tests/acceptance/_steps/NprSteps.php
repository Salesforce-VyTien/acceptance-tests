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

  /**
   * Configure a donation form.
   *
   * @param $nid
   *   The nid of the donation form to configure.
   */
  public function configureDonationForm($nid) {
    $I = $this;
    $I->amOnPage("springboard/node/$nid/edit");

    // Make sure the minimum amount is numeric.
    $amount = $I->grabValueFrom('#edit-amount-wrapper-minimum-donation-amount');
    $amount = trim(str_replace(',', '', $amount));
    $I->fillField('#edit-amount-wrapper-minimum-donation-amount', $amount);

    // Payment Methods is the 2nd vertical tab.
    $I->click('.vertical-tab-button:nth-child(2) a');
    $I->selectOption('#edit-gateways-credit-id', 'Test Gateway');
    $I->selectOption('#edit-gateways-bank-account-id', 'NPR Sage EFT');
    $I->click('Save');
    $I->canSee('has been updated', '.alert-success');

    // Confirm things saved.
    $I->amOnPage("springboard/node/$nid/edit");
    $I->click('.vertical-tab-button:nth-child(2) a');
    $I->seeOptionIsSelected('#edit-gateways-credit-id', 'Test Gateway');
    $I->seeOptionIsSelected('#edit-gateways-bank-account-id', 'NPR Sage EFT');

    // Settings from .yml files.
    $config = \Codeception\Configuration::config();
    $settings = \Codeception\Configuration::suiteSettings('acceptance', $config);
    $subdirectory = isset ($settings['General']['subdirectory']) ? $settings['General']['subdirectory'] : '';

    // Remove confirmation emails.
    $I->amOnPage("springboard/node/$nid/form-components/confirmation-emails");
    while ($delete_url = $I->executeJS('return jQuery("td>a:contains(\'Delete\'):first").attr("href")')) {
      if (strpos($delete_url, $subdirectory) === 0) {
        $delete_url = substr($delete_url, strlen($subdirectory));
      }
      $I->amOnPage($delete_url);
      $I->click('Delete');
      $I->seeInCurrentUrl('form-components/confirmation-emails');
      $I->dontSeeInCurrentUrl('delete');
    }
  }

  /**
   * Get list of active payment methods.
   *
   * @param array $skip
   *   Names of payment methods to omit from the list.
   *
   * @return array
   *   URLs of payment methods.
   */
  public function activePaymentMethods(array $skip = array()) {
    $I = $this;
    $I->amOnPage('admin/commerce/config/payment-methods');

    // Build the selector that selects the rules we want to disable.
    $selector = '.rules-overview-table:nth-child(3) .rules-element-label a';
    // Turn $skip into a string to insert into a jQuery selector.
    if ($skip) {
      foreach ($skip as $key => $value) {
        // @todo Use an exact match instead of :contains().
        $skip[$key] = ':contains("' . $value . '")';
      }
      $skip = implode(', ', $skip);
      $skip = ':not(' . $skip . ')';
      $selector .= $skip;
    }

    $js = "var links = jQuery('$selector');
      var urls_array = [];
      jQuery.each(links, function(index, value) {
        urls_array.push(jQuery(value).attr('href'));
      });
      return urls_array;";
    $rule_urls = $I->executeJS($js);

    return $rule_urls;
  }

  /**
   * Make a donation, NPR style.
   *
   * @param array $details
   *
   * @see \AcceptanceTester\SpringboardSteps::makeADonation().
   */
  public function makeNprDonation(array $details = array()) {
    $I = $this;

    $defaults = $I->donationData();
    $settings = array_merge($defaults, $details);

    $I->fillInMyName($settings['first_name'], $settings['last_name']);
    $I->fillField(\DonationFormPage::$emailField, $settings['mail']);
    $I->fillInMyAddress($settings['address'], $settings['address2'], $settings['city'], $settings['state'], $settings['zip'], $settings['country_name']);
    $I->checkOption('#edit-submitted-use-billing-address-1');

    switch ($details['payment_method']) {
      case 'bill_me_later':
        $I->click('//*/label[contains(text(),"Bill Me Later")]');
        break;

      case 'credit':
        $I->click('//*/label[contains(text(),"Credit Card")]');
        // @todo Enter CC details.
        break;

      case 'bank account':
        $I->click('//*/label[contains(text(),"Pay By Check")]');
        // @todo Enter bank account details.
        break;
    }

    $I->click('Submit');
  }

  /**
   * Find all offsite (to http*) redirects and delete them.
   *
   * This avoids issues with getting redirected to a whole different site when
   * you expect to remain on the tested site.
   */
  public function deleteOffsiteRedirects() {
    $I = $this;
    $I->amOnPage('/admin/config/search/redirect/list/http');
    // Check for presence of any offsite redirects.
    $empty = ($I->executeJS('return jQuery("td.empty").text()'));
    if (!$empty) {
      $I->checkOption('table.redirect-list-tableselect th.select-all input[type=checkbox]');
      $I->click('input[type=submit][name=op][value=Update]');
      $I->click('input[type=submit][name=op][value=Delete]');
      $I->canSee('Deleted', '.status');
    }
  }

  /**
   * Just like parent, but with less randomization.
   *
   * @inheritdoc
   */
  public function donationData() {
    $months = cal_info(0)['months'];
    $month_nums = array_keys($months);
    $request_time = strtotime('now');
    $form_data = array(
      'amount' => '10',
      'first_name' => 'Firstname',
      'last_name' => 'Lastname',
      'mail' => 'test_' . $request_time . '@example.com',
      'address' => '1234 Main St',
      'address2' => '',
      'city' => 'Washington',
      'state' => 'DC',
      'zip' => '20036',
      'country' => 'US',
      'country_name' => 'United States',
      'card_number' => '4111111111111111',
      'card_expiration_year' => date('Y', strtotime('+1 years')),
      'card_expiration_month_name' => $months[array_rand($months)],
      'card_expiration_month' => $month_nums[array_rand($month_nums)],
      'card_cvv' => rand(100, 999),
      // 'credit', 'bill_me_later', or 'bank account'.
      'payment_method' => 'credit',
    );
    return $form_data;
  }
}
