<?php

require_once SPRINGBOARD_MODULES_ROOT . 'springboard_api/resources/springboard_api.products.inc';

/**
 * @covers springboard_api_products_index().
 */
class SpringboardApiResourcesProductIndexTest extends UnitBaseTest {
  function setUp() {
    global $currentUnitTest;
    $currentUnitTest = get_called_class();
  }

  /**
   * Mock function of EntityFieldQuery class.
   *
   * @return array
   */
  public function entityFieldQueryMockExecute() {
    return array('commerce_product' => array(1 => 1));
  }

  public function testSpringboardApiResourcesProductIndex() {
    // Mock the functions in our target function.
    $this::createMockFunctionDefinition('entity_load');
    $item = array(
      'sku' => 'sku',
      'title' => 'title',
      'status' => 'status',
      'product_id' => 1,
      'type' => 'type',
    );
    $entities = array(
      (object) $item,
    );
    $this::stub('entity_load', $entities);

    $this::createMockFunctionDefinition('field_extract_bundle');
    $this::stub('field_extract_bundle', TRUE);

    $wrapper_mock = new SpringboardApiResourcesProductIndexWrapperMock();
    $this::createMockFunctionDefinition('entity_metadata_wrapper');
    $this::stub('entity_metadata_wrapper', $wrapper_mock);

    $this::createMockFunctionDefinition('field_info_instances');
    $field_instances = array(
      'field_name' => TRUE,
    );
    $this::stub('field_info_instances', $field_instances);

    // Exercise the springboard_api_products_index function.
    $result = springboard_api_products_index('type', 'apikey', 10, 0);

    // Verify it returned the items array plus the field.
    $expected = array($item + array('field_name' => 'field value'));
    $this->assertEquals($expected, $result);
  }

  public function __destruct() {
    // Clean up the stubbed values and mocked functions.
    $this::resetStubs();
    $this::resetMocks();
  }
}

/**
 * Class for mocking entity_metadata_wrapper().
 */
class SpringboardApiResourcesProductIndexWrapperMock {
  public $field_name;

  function __construct() {
    $this->field_name = new SpringboardApiResourcesProductIndexWrapperRawMock();
  }
}

/**
 * Class for mocking entity_metadata_wrapper().
 */
class SpringboardApiResourcesProductIndexWrapperRawMock {
  public function raw() {
    return 'field value';
  }
}
