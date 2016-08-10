# Springboard Acceptance Tests

## Requirements

 - Composer
 - Selenium Server
 - Firefox


## Installation

###Install Composer
You'll need Composer.  If you don't have it, install it globally from https://getcomposer.org/download/.

###Install Codeception
Clone this repo.  Run `composer install` to download the dependencies into the vendor directory.

The `codecept` binary is located in `vendor/codeception/codeception/codecept`.  You're going to want to either alias this or fiddle with your paths:
````
alias codecept=/the_path_to/acceptance-tests/vendor/codeception/codeception/codecept
````
Copy `codeception.yml.local` to `codeception.yml` and modify it to suite your environment. Do the same for `tests/acceptance.suite.yml.local` to `tests/acceptance.suite.yml`.

###Optionally Install Selenium Server Standalone and Selenium Browser Plugins

Get the Selenium server jar from here http://docs.seleniumhq.org/download/.  Save anywhere you want, but I put mine in the current directory. Selenium and Firefox have a mutual dependency. If you have the latest Firefox, odds are you'll need the latest Selenium.

In order to test with Firefox or Chrome, you will need to download geckodriver or chromedriver, put them somewhere in your path and make them executable.
If you have homebrew installed: `brew install geckodriver`

You would then start the Selenium server like so:

For Firefox:
java -jar /path_to/selenium-server-standalone-2.x.x.jar -Dwebdriver.gecko.driver="/path_to/geckodriver"

For Chrome:
java -jar /path_to/selenium-server-standalone-2.x.x.jar -Dwebdriver.chrome.driver="/path_to/chromedriver"'


## Running tests

By default, tests will run using PhantomJS and a headless browser rather than Selenium and Firefox. PhantomJS will start automatically.

You should be able to run the tests with `codecept run`.
You should be able to run an individual test with `codecept run tests/acceptance/path_to_test/testName.php`.

You should be able to run Selenium and Firefox browser tests with `codecept run --env=selenium_firefox`.
You should be able to run Selenium and Chrome browser tests with `codecept run --env=selenium_chrome`.

All tests will run in all environments, unless you specify an environment in the test:
put, for example, `// @env firefox_selenium` at the top of the test to have the tet only run in that environment.

Environment configurations can be added in the tests/_envs directory.

Add the `--html` switch to get a pretty report file.  Output ends up in `tests/_output`, which would include screenshots if a test fails.


## Create a new test

````
codecept generate:cept acceptance testName
````

And you'll end up with a test file in `tests/acceptance/testNameCept.php`. You should change the AcceptanceTester class to one of the _steps classes we have created depending on waht features you need.

## Basic acceptance testing

http://codeception.com/docs/04-AcceptanceTests

## Webdriver command reference
Most of these methods are available for both Selenium and PhantomJs tests.
http://codeception.com/docs/modules/WebDriver

## Springboard Test tips.
PhantomJS test run quickly. Often you will need to use webdriver's waitForElementVisible() method in order to click on a new or previously hidden element.

Clicking on a vertical or horizontal tab, or non-submit form item may require two clicks to register.

The default database should not have the  Drupal toolbar enabled.

The Springboard shortcut floating menu may need to be disabled temporarily in some tests,  as it interferes with element selection on some pages, using: $I->executeJS('jQuery("#springboard-admin-home-link").remove()');

If your test is failing, and the previous step to the fail was a form submission, the failure may be resulting from a form validation error preventing the submission from completing, which causes the next step to fail.


