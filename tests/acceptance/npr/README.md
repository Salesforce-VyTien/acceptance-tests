# Recommended test sequence

## Refresh database

In codeception.yml, set populate: true.

Manually delete all tables. (The codeception refresh function does not delete existing tables.)

## Set up gateways

`codecept run tests/acceptance/npr/0_setup_1_gateways --env=chrome_selenium`

## Prevent refreshing database on remaining runs

In codeception.yml, set populate: false.

## Set up donation forms

`codecept run tests/acceptance/npr/0_setup_2_donationforms`

## Remaining tests

Run the rest of the tests, one directory at a time.
