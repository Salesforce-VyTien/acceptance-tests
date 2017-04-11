<?php

// We assume that this script is being executed from the root of the Drupal
// installation.
define('DRUPAL_ROOT', getcwd() . '/');
define('SPRINGBOARD_MODULES_ROOT', DRUPAL_ROOT . 'sites/all/modules/springboard/');
require_once DRUPAL_ROOT . '/acceptance-tests/tests/phpunit/function_mock/function_mock.php';
