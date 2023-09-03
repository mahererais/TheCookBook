# reset password

- doc : https://symfony.com/doc/5.4/security/passwords.html#reset-password


```console
$ composer require symfonycasts/reset-password-bundle
```

- files created/upgrated : 
  - `config/packages/reset_password.yaml`
  - `config/bundles.php`

```console
$ php bin/console make:reset-password

Let's make a password reset feature!
====================================

 Implementing reset password for App\Entity\User

- ResetPasswordController -
---------------------------

 A named route is used for redirecting after a successful reset. Even a route that does not exist yet can be used here.

 What route should users be redirected to after their password has been successfully reset? [app_home]:
 > tcb_front_security_login

- Email -
---------

 These are used to generate the email code. Don't worry, you can change them in the code later!

 What email address will be used to send reset confirmations? e.g. mailer@your-domain.com:
 > no.reply.thecookbook@gmail.com

 What "name" should be associated with that email address? e.g. "Acme Mail Bot":
 > The Cook Book (Bot-No-Reply)

 created: src/Controller/ResetPasswordController.php
 created: src/Entity/ResetPasswordRequest.php
 updated: src/Entity/ResetPasswordRequest.php
 created: src/Repository/ResetPasswordRequestRepository.php
 updated: src/Repository/ResetPasswordRequestRepository.php
 updated: config/packages/reset_password.yaml
 created: src/Form/ResetPasswordRequestFormType.php
 created: src/Form/ChangePasswordFormType.php
 created: templates/reset_password/check_email.html.twig
 created: templates/reset_password/email.html.twig
 created: templates/reset_password/request.html.twig
 created: templates/reset_password/reset.html.twig
    
                   Success!            

 Next:
   1) Run "php bin/console make:migration" to generate a migration for the new "App\Entity\ResetPasswordRequest" entity.
   2) Review forms in "src/Form" to customize validation and labels.
   3) Review and customize the templates in `templates/reset_password`.
   4) Make sure your MAILER_DSN env var has the correct settings.
   5) Create a "forgot your password link" to the app_forgot_password_request route on your login form.

 Then open your browser, go to "/reset-password" and enjoy!
```