<?php

// Acceptance tests for admin UI and menus.
$I = new \AcceptanceTester\SpringboardSteps($scenario);
$I->wantTo('use the Springboard Admin UI to view reports');

for ($i = 0; $i <= 4; $i++) {
  $defaults = array(
    'email' => 'bob' . $i . '@example.com',
  );
  $I->amOnPage(DonationFormPage::$URL);
  $I->makeADonation($defaults);
}

$I->am('admin');
$I->wantTo('view the donation report.');
$I->login();
$I->seeInCurrentUrl('/springboard');

$I->moveMouseOver('li.reports');
$I->click('Donations');
$I->canSee('Order ID', 'th');
$I->canSee('Date', 'th');
$I->canSee('Amount', 'th');
$I->canSee('Name', 'th');
$I->canSee('E-mail', 'th');
$I->canSee('Form', 'th');
$I->canSee('Order status', 'th');
$I->canSee('Actions', 'th');

// The 5 donations made previously should be in the report.
for ($i = 0; $i <= 4; $i++) {
  $I->canSee('Bob' . $i . '@Example.Com', 'a');
}