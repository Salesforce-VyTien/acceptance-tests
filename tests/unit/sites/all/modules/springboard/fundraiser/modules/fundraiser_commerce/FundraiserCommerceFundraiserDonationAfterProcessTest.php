<?php

require_once SPRINGBOARD_MODULES_ROOT . 'fundraiser/fundraiser.module';
require_once SPRINGBOARD_MODULES_ROOT . 'fundraiser/modules/fundraiser_commerce/fundraiser_commerce.module';

/**
 * @covers fundraiser_commerce_fundraiser_donation_after_process().
 */
class FundraiserCommerceFundraiserDonationAfterProcessTest extends UnitBaseTest {
  // For tracking if the fetchAll() function runs.
  public $fetchAllRan = FALSE;

  public function setUp() {
    // Create mock data for the test.
    $this->commerce_order = (object) array(
      'uid' => 1,
      // Status set to false to avoid calling commerce status functions.
      'status' => FALSE,
    );

    $this->fundraiser_donation = (object) array(
      'result' => array(
        'success' => TRUE,
      ),
      'did' => 1,
      'data' => array(
        'cardonfile' => 13,
        'payment_method'=> 'credit',
        'payment_fields' => array(
          'credit' => array(
            'card_expiration_month'=> 11,
            'card_expiration_year' => 2022,
          ),
        ),
      ),
      'old_card' => (object) array(
        'card_exp_month' => 12,
        'card_exp_year' => 2020,
      ),
    );

    // Mock the functions we'll need for this test.
    $this::createMockFunctionDefinition('commerce_order_load');
    $this::createMockFunctionDefinition('user_load');
    $this::createMockFunctionDefinition('db_query');
    $this::createMockFunctionDefinition('commerce_cardonfile_load');
  }

  public function testFundraiserCommerceFundraiserDonationAfterProcess() {
    // For stubbing the db_query we pass in the expected sql and array of arguments.
    $dbquerysql = 'SELECT DISTINCT(fs.master_did), fd.did FROM {fundraiser_sustainers} fs LEFT JOIN {fundraiser_donation} fd ON fd.did = fs.did WHERE fd.card_id = :card_id';
    $dbquery_args = array(':card_id' => 13);
    // We pass in the test class to stub for setting the $fetchAllRan to true.
    $db_mock = new FundraiserCommerceFundraiserDonationAfterProcessDbMock($this);
    $this::stub('db_query', $db_mock, array($dbquerysql, $dbquery_args));

    $this::stub('commerce_order_load', $this->commerce_order);
    $this::stub('user_load', TRUE);
    $this::stub('commerce_cardonfile_load', TRUE);

    // Exercise the fundraiser_commerce_fundraiser_donation_after_process() function.
    fundraiser_commerce_fundraiser_donation_after_process($this->fundraiser_donation);

    /**
     * Verify the fetchAll() function ran.
     *
     * Confirms much of the code in our target function has run correctly.
     */
    $this->assertEquals(TRUE, $this->fetchAllRan);
  }

  public function __destruct() {
    // Clean up the stubbed values and mocked functions.
    $this::resetStubs();
    $this::resetMocks();
  }
}

/**
 * Class for mocking db_select.
 *
 * This class sets a variable on the test class for a later assertion.
 */
class FundraiserCommerceFundraiserDonationAfterProcessDbMock {
  function __construct() {
    $this->test = func_get_args()[0];
  }

  public function fetchAllAssoc() {
    $this->test->fetchAllRan = TRUE;
    return array();
  }
}
