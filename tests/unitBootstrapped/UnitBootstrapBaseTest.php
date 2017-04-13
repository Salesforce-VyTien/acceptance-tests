<?php

/**
 * Base class for Springboard Unit Bootstrapped Tests.
 */
class UnitBootstrapBaseTest extends \Codeception\Test\Unit {
  protected function setUp() {
    // Do not run the bootstrapped test if the FunctionMock class exist.
    if (class_exists('UnitBaseTest')) {
      $this->markTestSkipped(
        'This test did not run because it was not safe to bootstrap Drupal.'
      );
    }
    // Else, if Drupal has not been bootstrapped yet, do so.
    elseif (!defined('DRUPAL_BOOTSTRAP_FULL')) {
      // The chdir() and these variables are needed for the bootstrap process.
      chdir(DRUPAL_ROOT);
      require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
      $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

      // Bootstrap Drupal.
      drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
    }
  }
}
