<?php

class AdvocacyPage
{

  /**
  * Declare UI map for this page here. CSS or XPath allowed.
  * public static $usernameField = '#username';
  * public static $formSubmitButton = "#mainForm input[type=submit]";
  */


  //urls
  public static $settingsPage = 'admin/config/services/advocacy';

   /**
     * @var AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
      $this->acceptanceTester = $I;

    }

    /**
     * @return a thing.
     */
    public static function of(AcceptanceTester $I)
    {
        return new static($I);
    }

    function configureAdvocacy() {
      $config = \Codeception\Configuration::config();
      $settings = \Codeception\Configuration::suiteSettings('acceptance', $config);
      $I = $this->acceptanceTester;

      foreach ($settings['Advocacy'] as $key => $value) {
        $I->haveInDatabase('variable', array('name' => $key, 'value' => $value));
      }
    }
}

