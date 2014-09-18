  <?php

class P2pAdminPage
{
    // include url of current page
    public static $url = '/springboard/p2p';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * @var AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        $this->debugMode = '#edit-springboard-social-debug-mode';
  
    }

    /**
     * @return a thing.
     */
    public static function of(AcceptanceTester $I)
    {
        return new static($I);
    }

    function enableFeature() {
      $I = $this->acceptanceTester;
      $I->enableModule('Features');
      $I->amOnPage('admin/structure/features');
      $I->click("Springboard P2P",'.vertical-tabs');
      $I->checkOption('#edit-status-springboard-p2p');
      $I->click('#edit-submit');
    }

}
