<?php
/**
 * @file
 * Contains mocks of Drupal classes to support the unit tests.
 */

/**
 * Class EntityFieldQuery
 *
 * For mocking Drupal's EntityFieldQuer class in unit tests.
 *
 * In setUp() set the $currentUnitTest global variable:
 * $currentUnitTest = get_called_class();
 *
 * Then add the appropriate function to your test:
 * entityFieldQueryMockExecute() {};
 */
class EntityFieldQuery {

  public $currentUnitTest;

  function __construct() {
    global $currentUnitTest;
    $this->currentUnitTest = $currentUnitTest;
    $this->classMock = new $this->currentUnitTest;
  }

  public function __call($method, $arguments) {
    // Look in the current class being run and see if a mock function exists.
    $methodname = 'entityFieldQueryMock' . ucwords($method);
    if (method_exists($this->classMock, $methodname)) {
      return $this->classMock->{$methodname}($arguments);
    }
  }
}
