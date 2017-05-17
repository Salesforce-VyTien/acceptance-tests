<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Functional extends \Codeception\Module
{

  /**
   * Generates a random name.
   *
   * @param string $lastName
   *   An optional last name to use. You'll usually want it so that it
   *   identifies the payment gateway.
   *
   * @return string
   *   A random name.
   */
  public function randomInfo($lastName = 'Authorize') {
    $names = array(
      'Damian',
      'Ayana',
      'Shenna',
      'Marjorie',
      'Orville',
      'Theda',
      'Dianne',
      'Kerry',
      'Dixie',
      'Deangelo',
      'Alberto',
      'Kendrick',
      'Renna',
      'Hassie',
      'Fransisca',
      'Kirby',
      'Sherita',
      'Laticia',
      'Yee',
      'Awilda',
      'Rhoda',
      'Rosalinda',
      'Thomas',
      'Shae',
      'Vickie',
      'Tyler',
      'Alita',
      'Fredda',
      'Buck',
      'Truman',
      'Albertha',
      'Miesha',
      'Waneta',
      'Patrica',
      'Maile',
      'Son',
      'Teddy',
      'Duncan',
      'Amina',
      'Charlene',
      'Le',
      'Maxie',
      'Miki',
      'Robbie',
      'Caren',
      'Tamisha',
      'Loreta',
      'Mariann',
      'Abbie',
      'Rodolfo',
    );
    $firstName = $names[rand(0, 49)];
    $randomNumber = '';
    while (strlen($randomNumber) < 5) {
      $randomNumber .= rand(0, 9);
    }
    $email = strtolower($firstName) . '.' . strtolower($lastName) . $randomNumber . '@mailinator.com';

    return array($firstName, $lastName, $email);
  }

  /**
   * Get the year two years future from the current year.
   *
   * @return string
   *   The year it will be two years from now.
   */
  public function twoYearsFromNow() {
    return date('Y', strtotime('+2 years'));
  }

}
