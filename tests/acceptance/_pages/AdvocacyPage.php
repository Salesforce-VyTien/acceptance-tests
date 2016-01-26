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
    if (empty($_ENV['springboard_advocacy_server_url'])) {
      $config = \Codeception\Configuration::config();
      $settings = \Codeception\Configuration::suiteSettings('acceptance', $config);
    }
    else {
      // Scrutinizer env vars.
      $settings['Advocacy'] = array(
        'springboard_advocacy_server_url' => serialize($_ENV['springboard_advocacy_server_url']),
        'springboard_advocacy_client_id' => serialize($_ENV['springboard_advocacy_client_id']),
        'springboard_advocacy_client_secret' => serialize($_ENV['springboard_advocacy_client_secret']),
        'springboard_advocacy_smarty_authid' => serialize($_ENV['springboard_advocacy_smarty_authid']),
        'springboard_advocacy_smarty_authtoken' => serialize($_ENV['springboard_advocacy_smarty_authtoken']),
        'social_action_twitter_consumer_key' => serialize($_ENV['social_action_twitter_consumer_key']),
        'social_action_twitter_consumer_secret' => serialize($_ENV['social_action_twitter_consumer_secret']),
        'springboard_advocacy_test_email' => serialize($_ENV['springboard_advocacy_test_email']),
      );
    }
    $I = $this->acceptanceTester;

    foreach ($settings['Advocacy'] as $key => $value) {
      $I->haveInDatabase('variable', array('name' => $key, 'value' => $value));
    }
  }

  function twitterLogin() {
    if (empty($_ENV['twitter_name'])) {
      $config = \Codeception\Configuration::config();
      $settings = \Codeception\Configuration::suiteSettings('acceptance', $config);
    }
    else {
      // Scrutinizer env vars.
      $settings['Twitter'] = array('name' => $_ENV['twitter_name'], 'pass' => $_ENV['twitter_pass']);
    }

    $I = $this->acceptanceTester;
    $I->fillField('#username_or_email', $settings['Twitter']['name']);
    $I->fillField('#password', $settings['Twitter']['pass']);
    $I->click('#allow');
  }
}

