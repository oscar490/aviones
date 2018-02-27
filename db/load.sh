#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U aviones -d aviones < $BASE_DIR/aviones.sql
fi
psql -h localhost -U aviones -d aviones_test < $BASE_DIR/aviones.sql
