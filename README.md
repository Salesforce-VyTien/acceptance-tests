# Springboard Acceptance Tests

## Requirements

 - Composer

## Installation

###Install Composer
You'll need Composer.  If you don't have it, install it globally from https://getcomposer.org/download/.

###Install Codeception
Clone this repo.  From within the acceptance-tests directory run `composer install`
to download the dependencies into the vendor directory.

The `codecept` binary is located in `vendor/codeception/codeception/codecept`.
You're going to want to either alias this or fiddle with your paths:
````
alias codecept=/the_path_to/acceptance-tests/vendor/codeception/codeception/codecept
````
Copy `codeception.yml.local` to `codeception.yml` and modify it to suit your environment.
Do the same for `tests/acceptance.suite.yml.local` to `tests/acceptance.suite.yml`.

###Optionally Install Selenium Server Standalone and Selenium Browser Plugins

The tests run by default with the built-in PhantomJs server and headless browser, so you don't need
to do this step unless you want to watch the tests in a real browser (to observe php notices and
other issues that don't force an error).

In order to test with Firefox or Chrome and other browsers, you will need to download Selenium Standalone Server,
GeckoDriver (aka Marionette) or ChromeDriver, put them somewhere in your path and make them executable.

You'll want versions compatible with Selenium 2.53.1. Selenium 3 is not stable.
Firefox 48+ no longer works natively with Selenium, you must use GeckoDriver.
ChromeDriver is more stable at the moment. Use ChromeDriver

If you have homebrew installed: `brew install geckodriver` or `brew install chromedriver` or download manually:

* https://github.com/mozilla/geckodriver/releases (v0.9.0).
* https://sites.google.com/a/chromium.org/chromedriver/ (2.23+)

Get the Selenium Standalone Server jar file version 2.53.1 from here:

* http://selenium-release.storage.googleapis.com/2.53/selenium-server-standalone-2.53.1.jar

Save anywhere you want.

You would then start the Selenium server like so:

For Firefox:
`java -jar /path_to/selenium-server-standalone-2.x.x.jar -Dwebdriver.gecko.driver="/path_to/geckodriver"`

For Chrome:
`java -jar /path_to/selenium-server-standalone-2.x.x.jar -Dwebdriver.chrome.driver="/path_to/chromedriver"`


## Running tests

By default, tests will run using PhantomJS server and a headless browser. PhantomJS will start automatically.

Headless tests run 2x as fast as browser tests.

You should be able to run the tests with `codecept run`.
You should be able to run an individual test with `codecept run tests/acceptance/path_to_test/testName.php`.

### Running tests in environments
You should be able to run Selenium and Firefox browser tests with `codecept run --env=selenium_firefox`.

You should be able to run Selenium and Chrome browser tests with `codecept run --env=selenium_chrome`.

All tests will run in all environments, unless you specify an environment in the test:
put, for example, `// @env firefox_selenium` at the top of the test to have the test only run in that environment.

Environment configurations can be added in the tests/_envs directory.

### Running tests in groups
You can creates groups by putting a comment with a group name at the top of each test in the group:

//@group group_name

`codecept run -g group_name`


###Debugging tests
Output ends up in `tests/_output`, which would include screenshots if a test fails.

Add the `--html` switch to get a pretty report file.

To print test steps to console: `codecept run -vv test_name`

To receive detailed output, tests can be executed with the --debug option or
`codecept run -vvv test_name`

You may print any information inside a test to the console using the codecept_debug() function.

You can pause execution within a test using the $I->pauseExecution().
The test will stop the scenario in that place and wait for Enter to be pressed.
The pauseExecution works only in debug mode  (-vv or -vvv or --debug).

Pausing is most helpful during browser tests.

To get a screenshot during a particular step of a test (especially good for headless browser):
$I->makeScreenshot('name_of_my_screenshot');
// saved to: tests/_output/debug/name_of_my_screenshot.png

## Create a new test

````
codecept generate:cept acceptance testName
````

And you'll end up with a test file in `tests/acceptance/testNameCept.php`.
You should change the AcceptanceTester class to one of the _steps classes
we have created depending on what features you need.

## Basic acceptance testing

http://codeception.com/docs/04-AcceptanceTests

## Webdriver command reference
Most of these methods are available for both Selenium and PhantomJs tests.
http://codeception.com/docs/modules/WebDriver

## Springboard Testing Tips.

### Configure Advocacy, Salesforce, PayPal, and the Sustainers Key Location

Instructions and yaml templates are in acceptance.suite.yml.local.

### Some problems you might encounter

PhantomJS test run quickly. Often you will need to use webdriver's waitForElementVisible() method in order to click on a new or previously hidden element.

Clicking on a vertical or horizontal tab, or non-submit form item may require two clicks to register.

The default database should not have the  Drupal toolbar enabled.

The Springboard shortcut floating menu may need to be disabled temporarily in some tests,  as it interferes with element selection on some pages, using: $I->executeJS('jQuery("#springboard-admin-home-link").remove()');

If your test is failing, and the previous step to the fail was a form submission, the failure may be resulting from a form validation error preventing the submission from completing, which causes the next step to fail.


