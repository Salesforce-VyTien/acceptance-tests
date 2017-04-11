<?php

// We assume that this script is being executed from the root of the Drupal
// installation.
define('DRUPAL_ROOT', getcwd() . '/');
define('SPRINGBOARD_MODULES_ROOT', DRUPAL_ROOT . 'sites/all/modules/springboard/');

// Include the function mocking library.
require_once DRUPAL_ROOT . '/acceptance-tests/vendor/myplanetdigital/function_mock/function_mock.php';
