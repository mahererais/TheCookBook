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

rm -f vendor/;

composer install --no-dev --optimize-autoloader;

composer dump-env prod;

composer update --no-dev --optimize-autoloader;

APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear;

echo  "${RED}is it the first time you switch to prod ? [yes/no] (default no)\n${NC}";
read REPLY;
if [ "$REPLY" != "yes" ]; then
   exit
fi

composer require symfony/apache-pack;


sudo apt-get install -y acl;

sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var;

sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var;

sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var;
