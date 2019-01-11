#!/usr/bin/env bash

if [[ $1 ]]
then
    phpUnitFilter="--filter=$1"
else
    phpUnitFilter=""
fi

envOverridingCommand="export APP_ENV=\"testing\" && "

command+="$envOverridingCommand vendor/phpunit/phpunit/phpunit $phpUnitFilter"

docker exec nightclub_app bash -c "$command"

# exec command = ./run_tests.sh login
