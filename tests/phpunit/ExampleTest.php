<?php

/**
 * @covers bootstrap test
 */
final class ExampleTest extends PHPUnit_Framework_TestCase {
  public function testDrupalBootstrap() {
    // Arbritary function to ensure Drupal is bootstrapped properly.
    $this->assertEquals("test", check_plain("test"));
  }
}
