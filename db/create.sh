#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE aviones_test;"
    psql -U postgres -c "CREATE USER aviones PASSWORD 'aviones' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists aviones
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists aviones_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists aviones
    sudo -u postgres psql -c "CREATE USER aviones PASSWORD 'aviones' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O aviones aviones
    sudo -u postgres createdb -O aviones aviones_test
    LINE="localhost:5432:*:aviones:aviones"
    FILE=~/.pgpass
    if [ ! -f $FILE ]
    then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE
    then
        echo "$LINE" >> $FILE
    fi
fi
