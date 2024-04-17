## installation en dev

- add `.env.local`
- ***APP_ENV=dev***
- install `wkhtmltopdf`
- `sudo apt install wkhtmltopdf`
- install vendor
- `composer install`
- `php bin/console do:da:cr`
- `php bin/console do:mi:mi`

## add fixture 

- `php bin/console do:fi:lo`


## installation en production

- `sh migration/prod.sh`