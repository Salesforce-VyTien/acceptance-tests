<?php

require_once SPRINGBOARD_MODULES_ROOT . 'fundraiser/modules/fundraiser_sustainers/fundraiser_sustainers.module';

class FundraiserWIthMockingTest extends PHPUnit_Framework_TestCase {
  public function __construct() {
    // Generate all functions that need mocks from the module.
    FunctionMock::generateMockFunctions(
      array(
        SPRINGBOARD_MODULES_ROOT . 'fundraiser/modules/fundraiser_sustainers/fundraiser_sustainers.module',
      )
    );
  }

  public function testFundraiserWIthMocking() {
    // Stub the variable_get().
    FunctionMock::stub('variable_get', 3);

    // Stub the database functions.
    $db_query = new testFundraiserWIthMockingDbSelect();
    $db_or = new testFundraiserWIthMockingDbOr();
    $db_and = new testFundraiserWIthMockingDbAnd();
    FunctionMock::stub('db_select', $db_query);
    FunctionMock::stub('db_or', $db_or);
    FunctionMock::stub('db_and', $db_and);

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

class testFundraiserWIthMockingDbSelect {
  public function fields() {}
  public function leftJoin() {}
  public function condition() {}
  public function execute() {
    return new testFundraiserWIthMockingDbExecute();
  }
}

class testFundraiserWIthMockingDbOr {
  public function condition() {}
  public function isNull() {}
}

class testFundraiserWIthMockingDbAnd {
  public function condition() {}
}

class testFundraiserWIthMockingDbExecute {
  public function fetchAll() {
    return array();
  }
}
