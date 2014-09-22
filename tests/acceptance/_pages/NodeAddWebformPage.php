<?php

class NodeAddWebformPage
{
    // include url of current page
    public static $URL = '/node/add/webform';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $titleField = '#edit-title';
    public static $bodyField = '#edit-body-und-0-value';
    public static $internalNameField = '#edit-field-webform-user-internal-name-und-0-value';
    public static $URLAliasField = '#edit-path-alias';
    public static $saveButton = '#edit-submit';
    public static $pathSettingsTab = 'URL path settings';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: EditPage::route('/123-post');
     */
     public static function route($param)
     {
        return static::$URL.$param;
     }

    /**
     * @var AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    /**
     * @return NodeAddPagePage
     */
    public static function of(AcceptanceTester $I)
    {
        return new static($I);
    }
}
