<?php

namespace App\Controller\Front;

use App\Entity\Recipe;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/users", name="tcb_front_user_getAll")
     */
    public function getAll(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // = retrieve all users with role 'user' and status 'public'  
        $users = $userRepository->findByRoleAndStatus('user', "public");
        
        $users = $paginator->paginate(
            $users, // = my datas
            $request->query->getInt('page', 1), // = get page number in request url, and set page default to "1"
            5 // = limit by page
        );

        return $this->render('Front/user/chefs.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/query", name="tcb_front_user_search")
     */
    public function search(PaginatorInterface $paginator, UserRepository $userRepository, Request $request): Response
    {
        $users = $userRepository->searchUser($request->get("search"));

        $users = $paginator->paginate(
            $users, // = my datas
            $request->query->getInt('page', 1), // = get page number in request url, and set page default to "1"
            2 // = limit by page
        );

        return $this->render('Front/user/search.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/{slug}", name="tcb_front_user_show")
     */
    public function show(User $user, $slug): Response
    {
        $recipe = $this->entityManager->getRepository(User::class)->findOneBy(['slug' => $slug]);

        return $this->render('Front/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     *  @Route("/profile/update/{slug}", name="tcb_front_user_update")
     */
    public function update(Request $request, EntityManagerInterface $entityManager, User $user, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            // = je ne trouve pas d'autre solution mais il faut a nouveau checker si le mot de passe est valide
            // = parce que même quand l'utilisateur ne renseigne pas de mot de passe (champs vide), le "formulaire" est valide 
            // = $form->isValid() retourne true 
            // TODO : notre regex, on le repete pas mal de fois, faudrait essayer de l'avoir en parametre de class (static)
            if(preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/", $form->get('plainPassword')->getData()) ) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }
               
            //= I get the url of the image
            $picture = $request->attributes->get('user')->getPicture();
            // = I get the url of the coudinary image
            $imageCloudUrl =  $request->get("cloudinaryUrl"); 
            //= if the url of the image doesn't exist
            if(!$picture) {
                // = I add the upload
                $user->setPicture($imageCloudUrl);
            // = if the url of the image exist and the url of cloudinary image doesn't exist
            }elseif ($picture && !$imageCloudUrl) {
                // = I leave the url of the existing image
                $user->setPicture($picture);
            // = if the url of the image and the url of the cloudinary image exist 
            }else {
                // = I add the upload
                $user->setPicture($imageCloudUrl);
            }

            $entityManager->persist($user);
            
            $entityManager->flush();

            // flash message to add
            $this->addFlash("success", "L'utilisateur a bien mis à jour !");


            return $this->redirectToRoute('tcb_front_user_profile', ['slug' => $user->getSlug()]);
        }

        return $this->renderForm("Front/user/update.html.twig", [
            "form" => $form,
            "user" => $user
        ]);
    }

    /**
     * @Route("/profile/{slug}", name="tcb_front_user_profile")
     */
    public function profile(Request $request, EntityManagerInterface $entityManager, User $user, Security $security, UserRepository $userRepository, $slug): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);

        $user = $userRepository->findOneBy(['slug' => $slug]);
        return $this->render('Front/user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /** Get the recipes of a logged user
     * @Route("/profile/{slug}/recipes", name="tcb_front_user_getRecipesByUserLog")
     */
    public function getRecipesByUserLog(Request $request, RecipeRepository $recipeRepository, User $user, Security $security): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);
        $recipes = $this->getUser()->getRecipes();

        $userRecipesByCategory = [];
        foreach ($recipes as $recipe) {
            $categoryTitle = $recipe->getCategory()->getTitle();
            $userRecipesByCategory[$categoryTitle][] = $recipe;
        }
        ksort($userRecipesByCategory);

        return $this->render('Front/user/recipes.html.twig', [
            'userRecipesByCategory' => $userRecipesByCategory,
        ]);
    }

    /**
     * @Route("/profile/{slug}/ebook", name="tcb_front_user_ebook")
     */
    public function ebook(Request $request, EntityManagerInterface $entityManager, User $user, Security $security, RecipeRepository $recipeRepository): Response
    {
        $this->denyAccessUnlessGranted('PROFILE_ACCESS', $user);
        $ebookRecipes = $recipeRepository->findBy([
            'user' => $user,
            'ebook' => true,
        ],  ['category' => 'ASC']);

        $recipesByCategories = [];

        // = for each recipe of the array of categories
        foreach ($ebookRecipes as $recipe) {
      
           $recipesByCategories[$recipe->getCategory()->getTitle()][] = $recipe;
        }

        return $this->render('Front/user/ebook.html.twig', [
            'user' => $user,
            'ebookRecipes' => $recipesByCategories,
        
        ]);
    }

    /**
     * @Route("/profile/{slug}/ebook/delete/{recipeSlug}", name="tcb_front_user_removeFromEbook")
     */
    public function removeFromEbook(RecipeRepository $recipeRepository, $slug, $recipeSlug, EntityManagerInterface $entityManagerInterface): Response
    {
        $user = $this->getUser();
        $recipe = $recipeRepository->findOneBy([
            'slug' => $recipeSlug,
            'user' => $user
        ]);

        if ($recipe && $recipe->isEbook() === '1') {
            $recipe->removeFromEbook();

            $entityManagerInterface->flush();
            $this->addFlash("success", "La recette a été retirée de votre Ebook.");

            return $this->redirectToRoute('tcb_front_user_ebook', ['slug' => $slug]);
        }
    }

    /**
     * @Route("/add-favorite/{slug}", name="tcb_front_user_addFavorite")
     * @IsGranted("ROLE_USER")
     */
    public function addFavorite(Request $request, $slug, EntityManagerInterface $em, RecipeRepository $recipeRepository): Response
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();
        // je récupère mon user connecté

        if (!$user) {
            // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion ou affichez un message d'erreur
            return $this->redirectToRoute('tcb_front_security_login'); 
        }

        $recipe = $recipeRepository->findOneBy([
            'slug' => $slug
        ]);

        if (!$recipe) {
            // La recette n'a pas été trouvée, affichez un message d'erreur ou redirigez l'utilisateur
            return $this->redirectToRoute('tcb_front_recipe_getAll'); 
        }

        $user->addFavorite($recipe);
        $favorites = $user->getFavorites();

        $em->flush();

        // Afficher un message de succès
        $this->addFlash('success', 'La recette a été ajoutée à vos favoris.');

        return $this->redirectToRoute('tcb_front_recipe_getAll');
    }
}
