<?php
namespace AcceptanceTester;

class SpringboardSteps extends \AcceptanceTester\DrupalSteps
{
    public function makeADonation(array $details = array(), $recurs = FALSE)
    {
        $defaults = array(
            'email' => 'bob@example.com',
        );

        $settings = array_merge($defaults, $details);

        $I = $this;

        // @todo Use custom settings.
        $I->selectOption(\DonationFormPage::$askAmountField, '10');
        $I->fillInMyName();
        $I->fillField(\DonationFormPage::$emailField, $settings['email']);
        $I->fillInMyAddress();
        $I->fillInMyCreditCard();

        if ($recurs) {
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

    public function fillInMyAddress($address = '1234 Main St', $address2 = '', $city = 'Washington', $state = 'District Of Columbia', $zip = '00000', $country = 'United States') {
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

        $I->amOnPage('/node/' . $nid . '/clone');
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
        $I->click('Webform');
        $I->click('Form settings');
        $I->fillField('#edit-confirmation-confirmation-page-title', $pageTitle);
        $I->fillField('#edit-confirmation-value', $pageContent);
        $I->selectOption('confirmation[format]', 'full_html');
        $I->click('Save configuration');
    }
}
