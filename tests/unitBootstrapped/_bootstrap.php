<?php

/**
 * This file sets required constants and bootstraps Drupal for unit testing.
 *
 * By default the code assumes the test directory is located in the drupal root.
 *
 * If you require a different bootstrap process you can create a local
 * _bootstrap_dev.php in this directory.
 *
 */

// Get the directory of codeception and the current test directory.
define('UNIT_BOOTSTRAPPED_TEST_DIRECTORY', dirname(__FILE__));

if (!defined('CEPT_DIRECTORY')) {
  define('CEPT_DIRECTORY', getcwd());
}

// Load the local bootstrap file if it exists.
if (file_exists(UNIT_BOOTSTRAPPED_TEST_DIRECTORY. '/_bootstrap_dev.php')) {
  require_once UNIT_BOOTSTRAPPED_TEST_DIRECTORY . '/_bootstrap_dev.php';
}

if (!defined('DRUPAL_ROOT')) {
  define('DRUPAL_ROOT', rtrim(CEPT_DIRECTORY, 'acceptence-tests'));
}
