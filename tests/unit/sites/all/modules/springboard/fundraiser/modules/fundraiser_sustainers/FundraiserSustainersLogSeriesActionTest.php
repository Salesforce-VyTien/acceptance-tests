<?php

require_once SPRINGBOARD_MODULES_ROOT . 'fundraiser/modules/fundraiser_sustainers/fundraiser_sustainers.module';

/**
 * @covers fundraiser_sustainers_log_series_action().
 */
class FundraiserSustainersLogSeriesActionTest extends UnitBaseTest {
  public function testFundraiserSustainersLogSeriesAction() {
    $master_did = '101';
    $action = 'testing';
    $uid = '77';
    $metadata = [
      'int' => 5,
      'string' => 'value',
    ];

    // Mock and stub watchdog().
    $this::createMockFunctionDefinition('watchdog');

    // This stub will verify the arguments have been assembled correctly.
    $watchdog_args = [
      'fundraiser_sustainers_series_tracker',
      '|@master_did|@datetime|@uid|@action|int: @int|string: @string',
      [
        '@master_did' => $master_did,
        '@datetime' => date('c'),
        '@uid' => $uid,
        '@action' => $action,
        '@int' => 5,
        '@string' => 'value',
      ],
      6,
    ];
    $this::stub('watchdog', TRUE, $watchdog_args);

    // Exercising the function will fire the call to watchdog.
    fundraiser_sustainers_log_series_action($master_did, $action, $uid, $metadata);
  }
}
