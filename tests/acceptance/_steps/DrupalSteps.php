<?php
namespace AcceptanceTester;

class DrupalSteps extends \AcceptanceTester
{
    public function login($name = 'admin', $password = 'admin')
    {
        $I = $this;
        $I->amOnPage(\UserPage::$URL);
        $I->fillField(\UserPage::$usernameField, $name);
        $I->fillField(\UserPage::$passwordField, $password);
        $I->click(\UserPage::$loginButton);
    }

    public function logout()
    {
        $I = $this;

        $I->amOnPage(\UserPage::route('/logout'));
    }

    public function installModule($module)
    {
        $this->enableModule($module);
    }

    public function enableModule($module)
    {
        $I = $this;

        $I->amOnPage(\ModulesPage::$URL);
        $I->checkOption($module);
        $I->click(\ModulesPage::$submitButton);

        $I->see('The configuration options have been saved.', '.messages');
    }
    public function disableModule($module)
    {
        $I = $this;

        $I->amOnPage(\ModulesPage::$URL);
        $I->uncheckOption($module);
        $I->click(\ModulesPage::$submitButton);

    }
    public function uninstallModule($module)
    {
        $I = $this;

        $I->disableModule($module);

        $I->amOnPage(\ModulesPage::route('/uninstall'));
        $I->checkOption($module);
        $I->click(\ModulesPage::$uninstallButton);

        // Confirmation page.
        $I->click(\ModulesPage::$uninstallButton);

        $I->see('The selected modules have been uninstalled.', '.messages');

    }
    public function runCron()
    {
        $I = $this;
    }
}
