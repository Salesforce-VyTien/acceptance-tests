<?php

class TicketsTabPage
{
    // include url of current page
    public static $URL = 'springboard/node/%nid/tickets';
    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: EditPage::route('/123-post');
     */
     public static function route($param)
     {
         $url = static::$URL;
         return str_replace('%nid', $param, $url);
     }

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    
    // generic variables
    public static $waitList = '//select[@name="fr_tickets_waitlist_form[und]"]';
    public static $closed = '//input[@name="fr_tickets_closed_is_closed[und]"]';


    /**
     * @var AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    /**
     * @return NodeAddPage
     */
    public static function of(AcceptanceTester $I)
    {
        return new static($I);
    }
}
