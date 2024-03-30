#!/bin/bash

# sh migrations/prod.sh
# ! ATTENTION: il faut avoir la ligne APP_ENV=prod avant de lancer cette commande

RED='\033[0;31m'; # red color
NC='\033[0m'; # No Color

echo  "${RED}don't forget add APP_ENV=prod to your .env.local... continue ? [yes/no] (default no)\n${NC}";
read REPLY;
if [ "$REPLY" != "yes" ]; then
   exit
fi

rm -fr vendor/;

composer require symfony/apache-pack;

composer install --no-dev --optimize-autoloader;

composer dump-env prod;

APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear;

APP_ENV=prod php bin/console cache:warmup

echo  "${RED}is it the first time you switch to prod ? [yes/no] (default no)\n${NC}";
read REPLY;
if [ "$REPLY" != "yes" ]; then
   exit
fi

sudo apt-get install -y acl;

sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var;

sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var;

sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var;
