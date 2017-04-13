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
if (!defined('TEST_DIRECTORY')) {
  define('TEST_DIRECTORY', dirname(__FILE__));
}

if (!defined('CEPT_DIRECTORY')) {
  define('CEPT_DIRECTORY', getcwd());
}

// Load the local bootstrap file if it exists.
if (file_exists(TEST_DIRECTORY. '/_bootstrap_dev.php')) {
  require_once TEST_DIRECTORY . '/_bootstrap_dev.php';
}

if (!defined('DRUPAL_ROOT')) {
  define('DRUPAL_ROOT', rtrim(CEPT_DIRECTORY, 'acceptence-tests'));
}

// If Drupal has not been bootstrapped yet, do so.
if (!defined('DRUPAL_BOOTSTRAP_FULL')) {
  // The, chdir(), constants and variables are needed for the bootstrap process.
  chdir(DRUPAL_ROOT);
  require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
  $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

  // Bootstrap Drupal.
  drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
}
