<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="tcb_front_security_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // set a default avatar url
            $user->setPicture("https://img.freepik.com/psd-premium/male-chef-3d-avatar-illustration-job-icon_173394-160.jpg?size=100");

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // ! l'envoie de mail de fonctionne plus (compte mailjet suspendu)
            // ! je valide le user inscrit directement sans passer par le mail pour le moment
            $user->setIsVerified(true);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success", "Votre compte a bien été créé. Connectez-vous maintenant.");
            //$this->addFlash("success", "Un email vous a été envoyé pour l'activation de votre compte");

            // do anything else you need here, like send an email
            // generate a signed url and email it to the user
            // $this->emailVerifier->sendEmailConfirmation(
            //     'tcb_verify_email',
            //     $user,
            //     (new TemplatedEmail())
            //         ->from(new Address('thecookbook.no.reply@gmail.com', 'The Cook Book (Bot-No-Reply)'))
            //         ->to($user->getEmail())
            //         ->subject('Veuillez confirmer votre Email')
            //         ->htmlTemplate('registration/confirmation_email.html.twig')
            //         ->context([
            //             "firstname" => $user->getFirstname(),
            //         ])
            // );

            return $this->redirectToRoute('tcb_front_security_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="tcb_verify_email")
     */
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var \App\Entity\User */
        $user = $this->getUser();

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('danger', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('tcb_front_security_register');
        } catch (Exception $exc) {
            $this->addFlash('warning', $exc->getMessage());

            return $this->redirectToRoute('tcb_front_main_home');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre email a bien été verifié');

        return $this->redirectToRoute('tcb_front_user_profile', ['slug' => $user->getSlug()]);
    }

    // /**
    //  * @Route("/re-send/email/verify", name="tcb_resend_email")
    //  */
    // public function reSendVerif()
    // {
    //     /** @var \App\Entity\User */
    //     $user = $this->getUser();

    //     if (!$user) {
    //         $this->addFlash("success", "Un email vous a été envoyé avec le lien d'activation");
    //         return $this->redirectToRoute("tcb_front_security_login");
    //     }

    //     $this->emailVerifier->sendEmailConfirmation(
    //         'tcb_verify_email',
    //         $user,
    //         (new TemplatedEmail())
    //             ->from(new Address('thecookbook.no.reply@gmail.com', 'The Cook Book (Bot-No-Reply)'))
    //             ->to($user->getEmail())
    //             ->subject('Veuillez confirmer votre Email')
    //             ->htmlTemplate('registration/confirmation_email.html.twig')
    //             ->context([
    //                 "firstname" => $user->getFirstname(),
    //             ])
    //     );

    //     return $this->redirectToRoute('tcb_front_security_login');
    // }
}
