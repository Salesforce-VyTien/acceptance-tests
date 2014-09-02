<?php
namespace AcceptanceTester;

class SpringboardSteps extends \AcceptanceTester\DrupalSteps
{
    public function makeADonation(array $details = array())
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

    public function cloneADonationForm() {
        $I = $this;

        $I->amOnPage('/node/2/clone');
        $I->click('Clone');

    }
}
