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
  // Directory to the drupal root.
  define('DRUPAL_ROOT', rtrim(CEPT_DIRECTORY, 'acceptence-tests'));
}

if (!defined('SPRINGBOARD_MODULES_ROOT')) {
  // Directory to the root of the springboard modules.
  define('SPRINGBOARD_MODULES_ROOT', DRUPAL_ROOT . 'sites/all/modules/springboard/');
}

require_once CEPT_DIRECTORY . '/vendor/autoload.php';
