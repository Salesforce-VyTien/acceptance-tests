<?php

require_once SPRINGBOARD_MODULES_ROOT . 'springboard/modules/springboard/modules/springboard_admin/springboard_admin.module';

/**
 * @covers The SB logo drop-down menu's setting field form validation function: _springboard_admin_logo_links_validate().
 */
class SpringboardAdminParseLogoMenuSettingFieldValidateTest extends UnitBaseTest {
  public function testSpringboardAdminParseLogoMenuSettingFieldValidate() {
    // Define various invalid row values for field "Springboard Logo Drop-Down Links":
    $invalid_values = array();
    $invalid_values[] = ''; // Empty string
    $invalid_values[] = 'Test|NOPE://google.com'; // Invalid protocol
    $invalid_values[] = 'Test|'; // Missing URL
    $invalid_values[] = '|https://google.com'; // Missing link title
    $invalid_values[] = '|'; // Missing link title and URL
    $invalid_values[] = 'https://google.com'; // URL only, no title or separator
    $invalid_values[] = 'Test'; // Link title only, no URL or separator
   
    // Define various valid row values for field "Springboard Logo Drop-Down Links":
    $valid_values = array();
    $valid_values[] = 'Test|https://google.com'; // One-word link title, https protocol
    $valid_values[] = 'Test|http://google.com'; // One-word link title, http protocol
    $valid_values[] = ' Test | http://google.com '; // Whitespace around both link title and link URL
    $valid_values[] = 'Test Label|https://google.com'; // Multi-word link title, https protocol
    $valid_values[] = 'Test Label|http://google.com'; // Multi-word link title, http protocol
    $valid_values[] = 'Test|https://google.com?a=1'; // One-word link title, https protocol + one parameter
    $valid_values[] = 'Test|https://google.com?a=1&b=2'; // One-word link title, https protocol + multiple params
   
    $form = array('menu' => array('springboard_logo_links' => array(
      '#parents' => array('springboard_logo_links'),
    )));
 
    // Test each invalid row value by itself:
    foreach ($invalid_values as $invalid_row_value) {
       $form_state = array('values' => array('springboard_logo_links' => $invalid_row_value));
       _springboard_admin_logo_links_validate($form, $form_state);

       // As errors are not returned, search for any error messages being set:      
       $errors = drupal_get_messages('error', TRUE);
       $this->assertTrue(!empty($errors));
    }

    // Test each valid row value by itself:
    foreach ($valid_values as $valid_row_value) {
       $form_state = array('values' => array('springboard_logo_links' => $valid_row_value));
       $result = _springboard_admin_logo_links_validate($form, $form_state);

       // As errors are not returned, search for any error messages being set:      
       $errors = drupal_get_messages('error', TRUE);
       $this->assertTrue(empty($errors));
    }
  }
}
