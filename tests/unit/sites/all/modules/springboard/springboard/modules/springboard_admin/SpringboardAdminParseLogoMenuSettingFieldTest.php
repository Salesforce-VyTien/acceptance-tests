<?php

require_once SPRINGBOARD_MODULES_ROOT . 'springboard/modules/springboard_admin/springboard_admin.module';

/**
 * @covers The SB logo drop-down menu's setting field's parse function: _springboard_admin_parse_header_logo_links().
 */
class SpringboardAdminParseLogoMenuSettingFieldTest extends UnitBaseTest {
  public function testSpringboardAdminParseLogoMenuSettingField() {
    $test_data = array(
      array(
        'input' => '', // Empty string
        'output' => array(
          '' => '',
        ),
      ),
      array(
        'input' => 'Test|https://google.com',  // Single row
        'output' => array(
          'Test' => 'https://google.com',
        ),
      ),
      array(
        'input' => 'Test|', // Missing URL
        'output' => array(
          'Test' => '',
        ),
      ),
      array(
        'input' => '|https://google.com', // Missing Label
        'output' => array(
          '' => 'https://google.com',
        ),
      ),
      array(
        'input' => 'Test|https://google.com' . "\n" . // Multiple rows
                   'Test2|https://yahoo.com',
        'output' => array(
          'Test' => 'https://google.com',
          'Test2' => 'https://yahoo.com',
        ),
      ),
      array(
        'input' => ' Test | https://google.com ', // Extra whitespace
        'output' => array(
          'Test' => 'https://google.com',
        ),
      ),
    );

    // Process each input string and compare its output array to the output array that is expected:
    foreach ($test_data as $test) {
      $output_array = _springboard_admin_parse_header_logo_links($test['input']);
      $this->assertEquals($output_array, $test['output']);
    }
  }
}
