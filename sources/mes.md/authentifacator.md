# Authenticator

- source : https://www.youtube.com/watch?v=aSFREcYh8N8
- doc symfo :https://symfony.com/doc/current/security.html#registering-the-user-hashing-passwords  

```console
$ php bin/console make:registration-form

 Creating a registration form for App\Entity\User

 Do you want to send an email to verify the user's email address after registration? (yes/no) [yes]:
 > yes

                                                                                                                        
 [WARNING] We're missing some important components. Don't forget to install these after you're finished.                
                                                                                                                        
           composer require symfony/mailer                                                                              
                                                                                                                        

 By default, users are required to be authenticated when they click the verification link that is emailed to them.
 This prevents the user from registering on their laptop, then clicking the link on their phone, without
 having to log in. To allow multi device email verification, we can embed a user id in the verification link.

 Would you like to include the user id in the verification link to allow anonymous email verification? (yes/no) [no]:
 > no

 What email address will be used to send registration confirmations? e.g. mailer@your-domain.com:
 > no.reply.thecookbook@gmail.com

 What "name" should be associated with that email address? e.g. "Acme Mail Bot":
 > The Cook Book (Bot-No-Replay)

 Do you want to automatically authenticate the user after registration? (yes/no) [yes]:
 > no

 What route should the user be redirected to after registration?:
  [0 ] tcb_admin_category_getAll
  [1 ] tcb_admin_category_delete
  [2 ] tcb_admin_category_add
  [3 ] tcb_admin_category_update
  [4 ] tcb_admin_recipe_home
  [5 ] tcb_admin_recipe_getAll
  [6 ] tcb_admin_recipe_show
  [7 ] tcb_admin_recipe_delete
  [8 ] tcb_admin_user_getAll
  [9 ] tcb_admin_user_show
  [10] tcb_admin_user_delete
  [11] tcb_front_category_getAll
  [12] tcb_front_category_show
  [13] tcb_front_main_home
  [14] tcb_front_main_pdf
  [15] tcb_front_recipe_getAll
  [16] tcb_front_recipe_search
  [17] tcb_front_recipe_add
  [18] tcb_front_recipe_update
  [19] tcb_front_recipe_delete
  [20] tcb_front_recipe_show
  [21] tcb_front_user_getAll
  [22] tcb_front_user_search
  [23] tcb_front_user_show
  [24] tcb_front_user_update
  [25] tcb_front_user_profile
  [26] tcb_front_user_getRecipesByUserLog
  [27] tcb_front_user_ebook
  [28] tcb_front_user_removeFromEbook
  [29] tcb_front_security_login
  [30] tcb_front_security_logout
  [31] _preview_error
  [32] _wdt
  [33] _profiler_home
  [34] _profiler_search
  [35] _profiler_search_bar
  [36] _profiler_phpinfo
  [37] _profiler_search_results
  [38] _profiler_open_file
  [39] _profiler
  [40] _profiler_router
  [41] _profiler_exception
  [42] _profiler_exception_css
 > 29

 updated: src/Entity/User.php
 created: src/Security/EmailVerifier.php
 created: templates/registration/confirmation_email.html.twig
 created: src/Form/RegistrationFormType.php
 created: src/Controller/RegistrationController.php
 created: templates/registration/register.html.twig

           
  Success! 
           

 Next:
 1) Install some missing packages:
      composer require symfony/mailer
 2) In RegistrationController::verifyUserEmail():
    * Customize the last redirectToRoute() after a successful email verification.
    * Make sure you're rendering success flash messages or change the $this->addFlash() line.
 3) Review and customize the form, controller, and templates as needed.
 4) Run "php bin/console make:migration" to generate a migration for the newly added User::isVerified property.

 Then open your browser, go to "/register" and enjoy your new form!
```

- installation de symfony mailer et mailjet
  
```console
$ composer require symfony/mailer
$ composer require symfony/mailjet-mailer
```