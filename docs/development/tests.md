# Tests

## Linting, unit tests and functional tests

    vagrant up && vagrant ssh
    make test
    make integration

## Test checkpassword script

    vagrant up && vagrant ssh
    bin/console doctrine:schema:create -n && bin/console doctrine:fixture:load -n && exit
    cd .. && tests/test_checkpassword_login.sh
