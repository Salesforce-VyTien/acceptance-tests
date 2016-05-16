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
    public static $closedDate = '//input[@name="fr_tickets_closed_close_date[und][0][value][date]"]';
    public static $closedOptions = '//input[@name="fr_tickets_closed_options[und]"]';
    public static $closedMessage = '//textarea[@name="fr_tickets_closed_message[und][0][value]"]';
    public static $closedRedirect = '//input[@name="fr_tickets_closed_redirect[und][0][value]"]';
    public static $soldOutOptions = '//input[@name="fr_tickets_sold_out_options[und]"]';
    public static $soldOutMessage = '//textarea[@name="fr_tickets_sold_out_message[und][0][value]"]';
    public static $soldOutRedirect = '//input[@name="fr_tickets_sold_out_redirect[und][0][value]"]';
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
