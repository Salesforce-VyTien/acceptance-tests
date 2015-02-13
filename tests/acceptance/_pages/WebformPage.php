<?php

class WebformPage
{
    // include url of current page
    public static $URL = '';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $addEmailButton = '#edit-add-button';

    public static $emailSubjectField = '#edit-subject-option-custom--2';
    public static $emailSubjectCustomField = '#edit-subject-custom--2';

    public static $emailFromAddressField = '#edit-from-address-option-custom--2';
    public static $emailFromAddressCustomField = '#edit-from-address-custom--2';

    public static $emailFromNameField = '#edit-from-name-option-custom--2';
    public static $emailFromNameCustomField = '#edit-from-name-custom--2';

    public static $emailWrappersHTMLMessage = '#edit-email-wrappers-html-message';
    public static $emailWrappersTextMessage = '#edit-email-wrappers-text-message';

    public static $saveEmailSettingsButton = '#edit-actions-submit';

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
     * @return EmailWrapperPage
     */
    public static function of(AcceptanceTester $I)
    {
        return new static($I);
    }
}
