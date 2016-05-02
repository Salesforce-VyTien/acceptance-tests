<?php
namespace AcceptanceTester;

class SpringboardSteps extends \AcceptanceTester\DrupalSteps
{
    public function makeADonation(array $details = array(), $recurs = FALSE, $dual_ask = FALSE, $recurring_only = FALSE) {
        $defaults = array(
          'ask' => '10',
          'first' => 'John',
          'last' => 'Tester',
          'email' => 'bob@example.com',
          'address' => '1234 Main St.',
          'address2' => '',
          'city' => 'Washington',
          'state' => 'DC',
          'zip' => '20036',
          'country' => 'United States',
          'number' => '4111111111111111',
          'year' => date('Y', strtotime('+ 1 year')),
          'month' => 'January',
          'cvv' => '666',
        );

        $settings = array_merge($defaults, $details);

        $I = $this;

        if (!$recurs || ($recurs && !$dual_ask)) {
            $I->selectOption(\DonationFormPage::$askAmountField, $settings['ask']);
        }
        elseif($recurs && $dual_ask) {
            $I->selectOption(\DonationFormPage::$recursAmountField, $settings['ask']);
        }

        $I->fillInMyName($settings['first'], $settings['last']);
        $I->fillField(\DonationFormPage::$emailField, $settings['email']);
        $I->fillInMyAddress($settings['address'], $settings['address2'], $settings['city'], $settings['state'], $settings['zip'], $settings['country']);
        $I->fillInMyCreditCard($settings['number'], $settings['year'], $settings['month'], $settings['cvv']);

        if ($recurs && !$dual_ask && !$recurring_only) {
            $I->selectOption(\DonationFormPage::$recursField, 'recurs');
        }

        $I->click(\DonationFormPage::$donateButton);
    }

    public function fillInMyName($first = 'John', $last = 'Tester') {
        $I = $this;
        $I->fillField(\DonationFormPage::$firstNameField, $first);
        $I->fillField(\DonationFormPage::$lastNameField, $last);
    }

    public function fillInMyCreditCard($number = '4111111111111111', $year = NULL, $month = 'January', $cvv = '456') {
        $I = $this;

        $I->fillField(\DonationFormPage::$creditCardNumberField, $number);
        $I->selectOption(\DonationFormPage::$creditCardExpirationMonthField, $month);

        if (is_null($year)) {
            $year = date('Y', strtotime('+ 1 year'));
        }

        $I->selectOption(\DonationFormPage::$creditCardExpirationYearField, $year);

        $I->fillField(\DonationFormPage::$CVVField, $cvv);
    }

    public function fillInMyAddress($address = '1234 Main St', $address2 = '', $city = 'Washington', $state = 'Maryland', $zip = '00000', $country = 'United States') {
        $I = $this;

        $I->fillField(\DonationFormPage::$addressField, $address);
        // @todo Address 2
        $I->fillField(\DonationFormPage::$cityField, $city);
        $I->selectOption(\DonationFormPage::$countryField, $country);
        $I->selectOption(\DonationFormPage::$stateField, $state);
        $I->fillField(\DonationFormPage::$zipField, $zip);
    }

    /**
     * Clones a donation form.
     *
     * @param $nid
     *   The node id of the form to clone. Defaults to the build in
     *   donation form nid.
     *
     * @return $nid of newly created form.
     */
    public function cloneADonationForm($nid = 2) {
        $I = $this;

        $I->amOnPage('/node/' . $nid . '/clone/confirm');
        $I->click('Clone');
        $cloneNid = $I->grabFromCurrentUrl('~/springboard/node/(\d+)/edit~');
        codecept_debug($cloneNid);
        return $cloneNid;
    }

    /**
     * Configures a confirmation page title and message.
     *
     * @param $nid
     *   The id of the form to configue.
     *
     * @param $pageTitle
     *   The title to user for the confirmation page.
     *
     * @param $pageContent
     *   The content to use for the confirmation page.
     */
    public function configureConfirmationPage($nid, $pageTitle, $pageContent) {
        $I = $this;

        $I->amOnPage('/node/' . $nid . '/edit');
        $I->click('Form components');
        $I->click('Confirmation page & settings');
        $I->fillField('#edit-confirmation-confirmation-page-title', $pageTitle);
        $I->fillField('#edit-confirmation-value', $pageContent);
        $I->selectOption('confirmation[format]', 'full_html');
        $I->click('Save configuration');
    }

    /**
     * Make multiple donations with random info.
     *
     * @param string $path
     *   The path of the donation form. For example, '/node/2'.
     * @param int $numberOfDonations
     *   How many donations to make.
     */
    public function makeMultipleDonations($path, $numberOfDonations = 10) {
        $I = $this;
        // Used in combination with an iterator number to create a unique email address on each donation.
        $request_time = strtotime('now');

        $I->am('a donor');
        $I->wantTo('donate.');

        $asks = array('10', '20', '50', '100');
        $firsts = array('Alice', 'Tom', 'TJ', 'Phillip', 'David', 'Shaun', 'Ben', 'Jennie', 'Sheena', 'Danny', 'Allen', 'Katie', 'Jeremy', 'Julia', 'Kate', 'Misty', 'Pat', 'Jenn', 'Joel', 'Katie', 'Matt', 'Meli', 'Jess');
        $lasts = array('Hendricks', 'Williamson', 'Griffen', 'Cave', 'Barbarisi', 'Brown', 'Clark', 'Corman', 'Donnelly', 'Englander', 'Freeman', 'Grills', 'Isett', 'Kulla-Mader', 'McKenney', 'McLaughlin', 'O\'Brien', 'Olivia', 'Rothschild', 'Shaw', 'Thomas', 'Trumbo', 'Walls');
        $numbers = array('4111111111111111');
        $months = cal_info(0)['months'];

        for ($iterator = 0; $iterator < $numberOfDonations; $iterator++) {
            $defaults = array(
                'ask' => $asks[array_rand($asks)],
                'first' => $firsts[array_rand($firsts)],
                'last' => $lasts[array_rand($lasts)],
                'email' => 'test_' . $iterator . '_' . $request_time . '@example.com',
                'address' => '1234 Main St',
                'address2' => '',
                'city' => 'Washington',
                'state' => 'DC',
                'zip' => '20036',
                'country' => 'United States',
                'number' => $numbers[array_rand($numbers)],
                'year' => date('Y', strtotime('+ ' . ($i + 1) % 14 . ' years')),
                'month' => $months[array_rand($months)],
                'cvv' => rand(100, 999),
            );

            $recurring = ($iterator % 2) ? TRUE : FALSE;
            $I->amOnPage($path);
            $I->makeADonation($defaults, $recurring);
        }
    }

    public function configureSecurePrepopulate($key, $iv) {
        $I = $this;

        $I->amOnPage('admin/config/system/secure-prepopulate');
        $I->fillField('#edit-secure-prepopulate-key', $key);
        $I->fillField('#edit-secure-prepopulate-iv', $iv);
        $I->click('#edit-submit');
        $I->seeInMessages('The configuration options have been saved.');
    }

    public function generateSecurePrepopulateToken() {
      $I = $this;
      $I->amOnPage('admin/config/system/secure-prepopulate/token_generator');
      $I->click("Secure Pre-populate Token");
      $I->fillField('#edit-first-name', 'Allen');
      $I->fillField('#edit-last-name', 'Freeman');
      $I->fillField('#edit-email', 'allen.freeman@example.com');
      $I->fillField('#edit-address', '12345 Test Dr');
      $I->fillField('#edit-address-line-2', 'Apt 2');
      $I->fillField('#edit-city', 'Springfield');
      $I->fillField('#edit-country', 'US');
      $I->fillField('#edit-state', 'IL');
      $I->fillField('#edit-zip', '55555');
      $I->click('#edit-submit');
      $afToken = $I->grabTextFrom('//*[@id="console"]/div[2]/ul/li[2]');
      codecept_debug($afToken);

      return $afToken;
    }

    public function configureEncrypt() {
        $I = $this;
        $I->amOnPage('admin/config/system/encrypt');
        $I->fillField('Secure Key Path', '/tmp');
        $I->click("Save configuration");
        $I->see('Key found and in secure place.');
    }

    public function generateSustainerUpgradeToken($amount, $uid, $did, $rollback = FALSE) {
        $I = $this;
        $I->amOnPage('admin/config/system/fundraiser/token_generator');
        $I->fillField('#edit-uid', $uid);
        $I->fillField('#edit-amount', $amount);
        $I->fillField('#edit-did', $did);
        if ($rollback == TRUE) {
            $I->selectOption('#edit-rollback', 1);
        }
        $I->click('#edit-submit');
        $afToken = $I->grabValueFrom('//div[@id="console"]//textarea');

        return $afToken;
    }
}
