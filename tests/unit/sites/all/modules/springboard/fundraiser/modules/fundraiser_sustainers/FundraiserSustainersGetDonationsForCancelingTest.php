<?php

require_once SPRINGBOARD_MODULES_ROOT . 'fundraiser/modules/fundraiser_sustainers/fundraiser_sustainers.module';

/**
 * @covers _fundraiser_sustainers_get_donations_for_canceling().
 */
class FundraiserSustainersGetDonationsForCancelingTest extends UnitBaseTest {
  public function testFundraiserSustainersGetDonationsForCancelingEmptyResult() {
    // Stub the variable_get().
    $this::createMockFunctionDefinition('variable_get');
    $this::stub('variable_get', 3);

    // Stub the database functions.
    $this::createMockFunctionDefinition('db_select');
    $this::createMockFunctionDefinition('db_or');
    $this::createMockFunctionDefinition('db_and');

    // Pass an empty array to the db_select mock class.
    $db_mock = new FundraiserSustainersGetDonationsForCancelingDbMock(array());
    $this::stub('db_select', $db_mock);
    $this::stub('db_or', $db_mock);
    $this::stub('db_and', $db_mock);

    // Exercise the _fundraiser_sustainers_get_donations_for_canceling() method.
    $result = _fundraiser_sustainers_get_donations_for_canceling(123);

    // Verify it returned an empty array.
    $this->assertEquals(array(), $result);
  }

  public function testFundraiserSustainersGetDonationsForCancelingResult() {
    // Stub the variable_get().
    $this::createMockFunctionDefinition('variable_get');
    $this::stub('variable_get', 3);

    // Stub the database functions.
    $this::createMockFunctionDefinition('db_select');
    $this::createMockFunctionDefinition('db_or');
    $this::createMockFunctionDefinition('db_and');

    // Pass a populated array to the db_select mock class.
    $args = array(123 => array());
    $db_mock = new FundraiserSustainersGetDonationsForCancelingDbMock($args);
    $this::stub('db_select', $db_mock);
    $this::stub('db_or', $db_mock);
    $this::stub('db_and', $db_mock);

    // Exercise the _fundraiser_sustainers_get_donations_for_canceling() method.
    $result = _fundraiser_sustainers_get_donations_for_canceling(123);

    // Verify it returned the array.
    $this->assertEquals($args, $result);
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
 * This class passes the argument to the execute() function.
 */
class FundraiserSustainersGetDonationsForCancelingDbMock {

  private $return = array();

  function __construct() {
    $this->return = func_get_args()[0];
  }

  public function fields() {}
  public function leftJoin() {}
  public function condition() {}
  public function isNull() {}
  public function execute() {
    return new FundraiserSustainersGetDonationsForCancelingDbFetchAllMock($this->return);
  }
}

/**
 * Class for mocking fetchAll() method of db_select.
 *
 * This class returns the arguments as the result.
 */
class FundraiserSustainersGetDonationsForCancelingDbFetchAllMock {

  private $return = array();

  function __construct() {
    $this->return = func_get_args()[0];
  }

  public function fetchAll() {
    return $this->return;
  }
}
