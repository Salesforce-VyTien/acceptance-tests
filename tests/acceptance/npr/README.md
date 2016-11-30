# Recommended test sequence

Refresh database. In codeception.yml, set populate: true.

Set up gateways.
`codecept run tests/acceptance/npr/0_setup_1_gateways --env=chrome_selenium`

Prevent refreshing database. In codeception.yml, set populate: false.

Set up donation forms.
`codecept run tests/acceptance/npr/0_setup_2_donationforms`

Run the rest of the tests, one directory at a time.
