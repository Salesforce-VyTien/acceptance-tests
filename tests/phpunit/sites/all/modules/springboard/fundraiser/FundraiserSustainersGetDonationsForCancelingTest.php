<?php

/**
 * @covers querying the database for canceling a donation series.
 */
final class FundraiserSustainersGetDonationsForCancelingTest extends PHPUnit_Framework_TestCase {
  public function testFundraiserSustainersGetDonationsForCancelingCountActive() {
    $active_series = _fundraiser_sustainers_get_donations_for_canceling(159);
    $this->assertEquals(36, count($active_series));
  }

  public function testFundraiserSustainersGetDonationsForCancelingCountCanceled() {
    $canceled_series = _fundraiser_sustainers_get_donations_for_canceling(326);
    $this->assertEquals(0, count($canceled_series));
  }

  public function testFundraiserSustainersGetDonationsForCancelingCountFailed() {
    $failed_series = _fundraiser_sustainers_get_donations_for_canceling(533);
    $this->assertEquals(0, count($failed_series));
  }
}
