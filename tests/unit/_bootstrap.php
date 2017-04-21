<?php

/**
 * This file sets required constants for unit testing Springboard Drupal code.
 *
 * By default the code assumes the test directory is located in the drupal root.
 *
 * If you have a different setup you can create a local _bootstrap_dev.php
 * in this directory.
 *
 */

// Set the directory of codeception and the current test directory.
define('UNIT_TEST_DIRECTORY', dirname(__FILE__));

if (!defined('CEPT_DIRECTORY')) {
  define('CEPT_DIRECTORY', getcwd());
}

// Load the local bootstrap file if it exists.
if (file_exists(UNIT_TEST_DIRECTORY. '/_bootstrap_dev.php')) {
  require_once UNIT_TEST_DIRECTORY . '/_bootstrap_dev.php';
}

if (!defined('DRUPAL_ROOT')) {
  // Go one level up for the Drupal root.
  define('DRUPAL_ROOT', dirname(CEPT_DIRECTORY) . '/');
}

if (!defined('SPRINGBOARD_MODULES_ROOT')) {
  // Directory to the root of the springboard modules.
  define('SPRINGBOARD_MODULES_ROOT', DRUPAL_ROOT . 'sites/all/modules/springboard/');
}

require_once CEPT_DIRECTORY . '/vendor/autoload.php';

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
    $methodname = 'entityFieldQueryMock' . strtoupper($method);
    if (method_exists($this->classMock, $methodname)) {
      return $this->classMock->{$methodname}($arguments);
    }
  }
}
