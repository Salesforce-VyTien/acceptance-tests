<?php

/**
 * Base class for Springboard Unit Tests.
 */
class UnitBaseTest extends \Codeception\Test\Unit {
  /**
   * Generate a function definition that can be stubbed for the function name.
   *
   * @param $functionName
   *   Function name you want a mock for.
   * @return
   *   PHP function definition code that was executed.
   */
  public function createMockFunctionDefinition ($functionName) {
    return FunctionMock::createMockFunctionDefinition($functionName);
  }

  /**
   * Sets up a stub value for a given mock function.
   *
   * @param $functionName
   *   The name of the function to retrieve the stubbed value from.
   * @param $returnValue
   *   The value that you want returned when the function is called.
   * @param $paramList
   *   Optional array of parameters you want an exact match on, so you can
   *   do a conditional stub.
   */
  public function stub($functionName, $returnValue, $paramList = NULL) {
    FunctionMock::stub($functionName, $returnValue, $paramList);
  }

  /**
   * Resets all the stubbed functions.
   */
  public static function resetStubs() {
    FunctionMock::resetStubs();
  }

  /**
   * Resets all the mocks.
   */
  public static function resetMocks() {
    FunctionMock::resetMocks();
  }
}
