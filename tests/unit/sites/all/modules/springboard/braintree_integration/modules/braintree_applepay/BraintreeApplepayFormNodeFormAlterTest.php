<?php

require_once SPRINGBOARD_MODULES_ROOT . 'braintree_integration/modules/braintree_applepay/braintree_applepay.module';

/**
 * @covers braintree_applepay_form_node_form_alter().
 */
class BraintreeApplepayFormNodeFormAlterTest extends UnitBaseTest {
  function testBraintreeApplepayIsPaymentMethod() {
    $method_id = 'braintree_applepay|commerce_payment_braintree_applepay';
    $this->assertTrue(_braintree_is_applepay_payment_method($method_id));
  }
}
