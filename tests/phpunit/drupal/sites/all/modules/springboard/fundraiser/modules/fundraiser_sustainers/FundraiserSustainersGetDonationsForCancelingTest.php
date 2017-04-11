<?php

require_once SPRINGBOARD_MODULES_ROOT . 'fundraiser/modules/fundraiser_sustainers/fundraiser_sustainers.module';

/**
 * @covers _fundraiser_sustainers_get_donations_for_canceling().
 */
class FundraiserSustainersGetDonationsForCancelingTest extends PHPUnit_Framework_TestCase {
  public function __construct() {
    // Generate all functions that need mocks from the module.
    //FunctionMock::generateMockFunctions(
    //  array(
    //    SPRINGBOARD_MODULES_ROOT . 'fundraiser/modules/fundraiser_sustainers/fundraiser_sustainers.module',
    //  )
    //);
  }

  public function testFundraiserSustainersGetDonationsForCanceling() {
    // Stub the variable_get().
    FunctionMock::createMockFunctionDefinition('variable_get');
    FunctionMock::stub('variable_get', 3);

    // Stub the database functions.
    FunctionMock::createMockFunctionDefinition('db_select');
    FunctionMock::createMockFunctionDefinition('db_or');
    FunctionMock::createMockFunctionDefinition('db_and');
    $db_mock = new FundraiserSustainersGetDonationsForCancelingDbMock();
    FunctionMock::stub('db_select', $db_mock);
    FunctionMock::stub('db_or', $db_mock);
    FunctionMock::stub('db_and', $db_mock);

    // Exercise the _fundraiser_sustainers_get_donations_for_canceling() method.
    $result = _fundraiser_sustainers_get_donations_for_canceling(123);

    // Verify it worked.
    $this->assertEquals(array(), $result);
  }

  public function __destruct() {
    // Clean up the stubbed values.
    FunctionMock::resetStubs();
  }
}

/**
 * Class for mocking db_select.
 */
class FundraiserSustainersGetDonationsForCancelingDbMock {
  public function fields() {}
  public function leftJoin() {}
  public function condition() {}
  public function isNull() {}
  public function execute() {
    return new FundraiserSustainersGetDonationsForCancelingDbFetchAllMock();
  }
}

/**
 * Class for mocking fetchAll() method of db_select.
 */
class FundraiserSustainersGetDonationsForCancelingDbFetchAllMock {
  public function fetchAll() {
    return array();
  }
}
