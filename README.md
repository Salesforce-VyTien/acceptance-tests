# Springboard Acceptance Tests

## Requirements

 - Composer
 - Selenium Server
 - Firefox

## Installation

You'll need composer.  If you don't have it, install it globablly from https://getcomposer.org/download/.

Clone this repo.  Run `composer install` to download the dependencies into the vendor directory.

Get the Selenium server jar from here http://docs.seleniumhq.org/download/.  Save anywhere you want, but I put mine in the current directory.  Start Selenium server with `java -jar selenium-server-standalone-x.x.x.jar`.

Copy `codeception.yml.local` to `codeception.yml` and modify it to suite your environment. Do the same for `tests/acceptance.suite.yml.local` to `tests/acceptance.suite.yml`.

The `codecept` binary is located in `vendor/codeception/codeception/codecept`.  You're going to want to either alias this or fiddle with your paths.

````
alias codecept=vendor/codeception/codeception/codecept
````

## Running tests

You should be able to run the tests with `codecept run`.
You should be able to run an individual test with `codecept run tests/acceptance/path_to_test/testName.php`.

Add the `--html` switch to get a pretty report file.  Output ends up in `tests/_output`, which would include screenshots if a test fails.

## Create a new test

````
codecept generate:cept acceptance testName
````

And you'll end up with a test file in `tests/acceptance/testNameCept.php`. You should change the AcceptanceTester class to one of the _steps classes we have created depending on waht features you need.

## Basic acceptance testing

http://codeception.com/docs/04-AcceptanceTests

## Webdriver documentation

https://github.com/Codeception/Codeception/blob/master/docs/modules/WebDriver.md
