<?php

require_once SPRINGBOARD_MODULES_ROOT . 'springboard_advocacy/modules/sba_quicksign/sba_quicksign.module';

/**
 * @covers sba_quicksign_webform_user_session_storage_cancel().
 */
class QuicksignSessionStorage extends UnitBaseTest {
  public function testQuicksignSessionCancel() {
    $form_state = array();
    $form_state['triggering_element'] = 1;
    $form_state['triggering_element']['#parents'] = array('not_sba_quicksign');

    $this->assertEquals(0, sba_quicksign_webform_user_session_storage_cancel($form_state), 'Not a quicksign');

    $form_state = array();
    $form_state['triggering_element'] = 1;
    $form_state['triggering_element']['#parents'] = array('not_sba_quicksign');

    $this->assertEquals(1, sba_quicksign_webform_user_session_storage_cancel($form_state), 'Quicksign');
  }

}

