#!/bin/bash

# at root project, execute current script with command below
# sh migrations/reload.dataBase.sh

echo "--- delete all table and tcb database ---";
php bin/console do:da:dr --force;

echo "--- create tcb database ---";
php bin/console do:da:cr;

echo "--- remove all migrations ---";
rm migrations/Version*.php;

echo "--- generate migration ---";
php bin/console ma:mi;


echo "--- create all table ---";
php bin/console do:mi:mi -n;

echo "--- load fake data ---";
php bin/console do:fi:lo -n;

