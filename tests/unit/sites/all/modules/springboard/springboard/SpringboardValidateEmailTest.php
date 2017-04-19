<?php

require_once SPRINGBOARD_MODULES_ROOT . 'springboard/springboard.module';

/**
 * @covers springboard_validate_email().
 */
class SpringboardValidateEmailTest extends UnitBaseTest {
  public function testSpringboardValidateEmail() {
    // Test the collective variety of emails. Failures.
    $emails = array();
    $emails[] = ''; // Empty string.
    $emails[] = '@'; // Only the designator.
    $emails[] = 'email'; // Only the name.
    $emails[] = 'email@'; // Only the name and and designator.
    $emails[] = '@com'; // Only the domain ending and designator.
    $emails[] = '@example.com'; // Only the domain.
    $emails[] = 'email@example'; // No domain ending.
    $emails[] = 'email@.com'; // No domain.
    $emails[] = '1Email!add@example.com'; // Invalid character in name.
    $emails[] = '1Email+add@!example.com'; // Invalid character in domain.
    $emails[] = '1Email+add@example.!com'; // Invalid character in domain ending.
    $emails[] = '1Email+add@example.c'; // Too short domain ending.
    $emails[] = '1Email+add@example.coooooom'; // Too long domain ending.
    $emails[] = '1Email+add@example.c0m'; // Invalid character in domain ending.
    foreach ($emails as $email) {
      // Test each email address by sending it directly through springboard's email validation function.
      $this->assertEquals(0, springboard_validate_email($email), sprintf('An invalid email address (%s) was not accepted.', $email));
    }

    // Test the collective variety of emails. Successes.
    $emails = array();
    $emails[] = 'email@example.com'; // Standard good email.
    $emails[] = 'Email@example.com'; // Good email with capital.
    $emails[] = '1Email.add@example.com'; // With additional punctuation.
    $emails[] = '1Email_add@example.com'; // With additional punctuation.
    $emails[] = '1Email%add@example.com'; // With additional punctuation.
    $emails[] = '1Email-add@example.com'; // With additional punctuation.
    $emails[] = '1Email+add@example.com'; // With additional punctuation.
    $emails[] = '1Email+add@sub.example.com'; // Wih a sub-domain.
    $emails[] = '1Email+add@sub-example.com'; // With additional punctuation.
    $emails[] = '1Email+add@sub-example.cm'; // Minimum length domain ending.
    $emails[] = '1Email+add@sub-example.coooom'; // Maximum length domain ending.
    foreach ($emails as $email) {
      // Test each email address by sending it directly through springboard's email validation function.
      $this->assertEquals(1, springboard_validate_email($email), sprintf('A valid email address (%s) was accepted.', $email));
    }
  }
}

