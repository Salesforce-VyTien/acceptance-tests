<?php

require_once SPRINGBOARD_MODULES_ROOT . 'fundraiser/modules/fundraiser_commerce_cardonfile/fundraiser_commerce_cardonfile.module';

/**
 * @covers fundraiser_commerce_cardonfile_form_fundraiser_update_billing_form_alter().
 */
class FundraiserCommerceCardonfileBillingUpdateFormAlterTest extends UnitBaseTest {
  // Mock of form array.
  private $form;

  // Mock of $form_state array.
  private $form_state;

  /**
   * Custom setUp().
   */
  public function setUp() {
    // Mock the functions we'll need for this test.
    $this::createMockFunctionDefinition('t');
    $this::stub('t', TRUE, array('You are editing billing information for:'));

    // t() is used create an expiration date string.
    $t_args = [
      'Expires: @month/@year',
      [
        '@month' => '03',
        '@year' => 28,
      ],
    ];
    $this::stub('t', TRUE, $t_args);

    // t() is called by l(), which expects 'Cancel' string.
    $this::stub('t', 'Cancel', array('Cancel'));

    // Verify the correct args are passed to format_string().
    $format_string_args = [
      '@type - XXXX-XXXX-XXXX-@number',
      [
        '@type' => 'VISA',
        '@number' => 1111,
      ],
    ];
    $this::createMockFunctionDefinition('format_string');
    $this::stub('format_string', TRUE, $format_string_args);

    // Verify the correct args are pass to l().
    $l_args = [
      'Cancel',
      'user/23/cards',
    ];
    $this::createMockFunctionDefinition('l');
    $this::stub('l', TRUE, $l_args);

    // Form and form_state array to be altered.
    $this->form = [
      '#calling_module' => 'fundraiser_commerce_cardonfile',
      '#donation' => (object) [
        'recurring' => (object) [
          'master_did' => 123
        ],
      ],
      'actions' => [
        'submit' => [
          '#submit' => [
            'fundraiser_sustainers_update_billing_form_submit',
          ],
        ],
      ],
      'billing_information' => [
        'address_update' => [
          '#submit' => [
            'fundraiser_sustainers_update_billing_address_only_form_submit',
          ],
        ],
      ],
    ];

    $this->form_state = [
      'card' => (object) [
        'card_type' => 'visa',
        'card_number' => 1111,
        'card_exp_month' => 3,
        'card_exp_year' => 28,
        'uid' => 23,
      ],
    ];
  }

  /*
   * Test the alter function with a recurring donation.
   */
  public function testFundraiserCommerceCardonfileBillingUpdateFormAlterRecurring() {
    $form = $this->form;
    $form_state = $this->form_state;

    // Exercise the form alter hook.
    fundraiser_commerce_cardonfile_form_fundraiser_update_billing_form_alter($form, $form_state);

    // Assert the submit handlers are the default ones.
    $expected_action_submit = [
      '#submit' => [
        'fundraiser_sustainers_update_billing_form_submit',
        'fundraiser_commerce_cardonfile_billing_update_form_submit_add_redirect',
      ],
    ];
    $this->assertEquals($expected_action_submit, $form['actions']['submit']);

    $expected_billing_submit = [
      '#submit' => [
        'fundraiser_sustainers_update_billing_address_only_form_submit',
        'fundraiser_commerce_cardonfile_billing_update_form_submit_add_redirect',
      ],
    ];
    $this->assertEquals($expected_billing_submit, $form['billing_information']['address_update']);
  }

  /**
   * Test the alter function with a one-time donation.
   */
  public function testFundraiserCommerceCardonfileBillingUpdateFormAlterOneTime() {
    $form = $this->form;
    // Unset the recurring value to trigger one-time submit handlers.
    unset($form['#donation']->recurring);
    $form_state = $this->form_state;

    // Exercise the form alter hook.
    fundraiser_commerce_cardonfile_form_fundraiser_update_billing_form_alter($form, $form_state);

    // Assert the submit handlers are correct.
    $expected_action_submit = [
      '#submit' => [
        1 => 'fundraiser_commerce_cardonfile_update_billing_form_submit',
        2 => 'fundraiser_commerce_cardonfile_billing_update_form_submit_add_redirect',
      ],
    ];

    $this->assertEquals($expected_action_submit, $form['actions']['submit']);

    $expected_billing_submit = [
      '#submit' => [
        1 => 'fundraiser_commerce_cardonfile_update_billing_address_only_form_submit',
        2 => 'fundraiser_commerce_cardonfile_billing_update_form_submit_add_redirect',
      ],
    ];
    $this->assertEquals($expected_billing_submit, $form['billing_information']['address_update']);
  }

  public function __destruct() {
    // Clean up the stubbed values and mocked functions.
    $this::resetStubs();
    $this::resetMocks();
  }
}
