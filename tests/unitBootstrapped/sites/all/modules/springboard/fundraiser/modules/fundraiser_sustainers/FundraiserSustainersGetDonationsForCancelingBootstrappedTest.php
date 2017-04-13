<?php

/**
 * @covers _fundraiser_sustainers_get_donations_for_canceling().
 */
final class FundraiserSustainersGetDonationsForCancelingBootstrappedTest extends UnitBootstrapBaseTest {
  public function testFundraiserSustainersGetDonationsForCancelingCompareActive() {
    // Run the expected db_select() and compare the results.
    $master_did = 159;
    $max_processing_attempts = variable_get('fundraiser_sustainers_max_processing_attempts', 3);

    // Build the query for selecting donations for canceling.
    $query = db_select('fundraiser_sustainers', 'r');
    $query->fields('r');
    $query->leftJoin('fundraiser_donation', 'd', 'r.did = d.did');
    $query->condition('r.master_did', $master_did);

    // Build an OR condition to filter on the gateway_resp value.
    $db_or = db_or();
    // Select donations that have not been charged.
    $db_or->isNull('r.gateway_resp');
    // Select donations that are in retry.
    $db_and = db_and();
    $db_and->condition('r.gateway_resp', FUNDRAISER_SUSTAINERS_RETRY_STATUS);
    $db_and->condition('r.attempts', $max_processing_attempts, '!=');
    $db_or->condition($db_and);
    // Select donations that are locked.
    $db_or->condition('r.gateway_resp', FUNDRAISER_SUSTAINERS_LOCKED_STATUS);
    $query->condition($db_or);

    $expected = $query->execute()->fetchAll();

    $active_series = _fundraiser_sustainers_get_donations_for_canceling($master_did);
    $this->assertEquals($expected, $active_series);
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
