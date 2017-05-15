<?php

require_once SPRINGBOARD_MODULES_ROOT . 'fundraiser/modules/fundraiser_sustainers/fundraiser_sustainers.module';

/**
 * @covers Matching donation status to series entity status.
 */
class FundraiserSustainersRecurringEntityStatusTest extends UnitBaseTest {
  public function testFundraiserSustainersRecurringEntityStatusMap() {
    $statuses = fundraiser_sustainers_series_entity_statuses();

    // Setup an array of donation status values matched to it's entity status.
    $matches = array(
      'pending_future_payment' => 'active',
      'payment_received' => 'expired',
      'offline_check' => 'expired',
      'canceled' => 'canceled',
      'omitted' => 'canceled',
      'auto_canceled' => 'auto_canceled',
      'failed' => 'failed',
      'unknown'=> 'failed',
    );

    foreach ($matches as $commerce_status => $entity_status) {
      // Match the order status to the array of series entity statuse.
      $this->assertTrue(in_array($commerce_status, $statuses[$entity_status]));
    }
  }
}
