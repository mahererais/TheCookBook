<?php

namespace App\Controller\Front;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\UserRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/recipes", name="tcb_front_recipe_getAll")
     */
    // = besoin de PaginatorInterface et de la requete 
    public function getAll( RecipeRepository $recipeRepository,
                            PaginatorInterface $paginator, 
                            Request $request): Response
    {
        $recipes = $recipeRepository->findRecipes(); 

        $recipes = $paginator->paginate(
            $recipes, // = my datas
            $request->query->getInt('page', 1), // = get page number in request url, and set page default to "1"
            5 // = limit by page
        );

        return $this->render('Front/recipe/list.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    /**
     * @Route("/recipe/query", name="tcb_front_recipe_search")
     */
    public function search(PaginatorInterface $paginator, RecipeRepository $recipeRepository, UserRepository $userRepository, Request $request): Response
    {
        $recipes = $recipeRepository->searchRecipe($request->get("search"));
        $users = $userRepository->searchUser($request->get("search"));

        $recipesUsers = $paginator->paginate(
            array_merge($recipes, $users), // = my datas
            $request->query->getInt('page', 1), // = get page number in request url, and set page default to "1"
            5 // = limit by page
        );
         // dd($users);

        return $this->render('Front/recipe/search.html.twig', [
            'recipesUsers' => $recipesUsers,
            // 'recipes' => $recipes,
            // 'users' => $users,
        ]);
    }

    /**
     *
     * @Route("/recipe/add", name="tcb_front_recipe_add")
     * 
     */
    public function add(Request $request, EntityManagerInterface $entityManager, Security $security, Recipe $recipe = null): Response
    {

        $recipe = new Recipe();
        $user = $security->getUser();

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setUser($user);

            $imageCloudUrl =  $request->get("cloudinaryUrl");
            $recipe->setPicture($imageCloudUrl);

            $entityManager->persist($recipe);
            $entityManager->flush();

            $this->addFlash("success", "Recette bien ajoutée !");

            return $this->redirectToRoute('tcb_front_recipe_getAll');
        }

        return $this->renderForm("Front/user/add_recipe.html.twig", [
            "form" => $form,
            "recipe"=> $recipe
        ]);
    }

    /**
     * 
     * @Route("/recipe/update/{slug}", name="tcb_front_recipe_update")
     *
     */
    public function update(Request $request, EntityManagerInterface $entityManager, string $slug, Recipe $recipe, RecipeRepository $recipeRepository ): Response
    {
        $this->denyAccessUnlessGranted('RECIPE_MODIF', $recipe);

        // ! pas besoin vu qu'on le recupere en argment de la function update(injection de dependance)
        // $recipe = $recipeRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            //= I get the url of the image
            $picture = $request->attributes->get('recipe')->getPicture();
            // = I get the url of the coudinary image
            $imageCloudUrl =  $request->get("cloudinaryUrl"); 
            //= if the url of the image doesn't exist
            if(!$picture) {
                // = I add the upload
                $recipe->setPicture($imageCloudUrl);
            // = if the url of the image exist and the url of cloudinary image doesn't exist
            }elseif ($picture && !$imageCloudUrl) {
                // = I leave the url of the existing image
                $recipe->setPicture($picture);
            // = if the url of the image and the url of the cloudinary image exist 
            }else {
                // = I add the upload
                $recipe->setPicture($imageCloudUrl);
            }

            $entityManager->persist($recipe);
            $entityManager->flush();

            $this->addFlash("success", "La recette a été modifiée.");

            return $this->redirectToRoute('tcb_front_recipe_show', ['slug' => $recipe->getSlug()]);
        }

        return $this->renderForm("Front/user/add_recipe.html.twig", [
            "form" => $form,
            "recipe" => $recipe,
        ]);
    }

    /**
     * 
     * @Route("/recipe/delete/{slug}", name="tcb_front_recipe_delete")
     */
    public function delete(RecipeRepository $recipeRepository, EntityManagerInterface $entityManager, string $slug, Request $request, Security $security): Response
    {
        $recipe = $recipeRepository->findOneBy(['slug' => $slug]);

        if (!$recipe) {
            $this->addFlash('danger', 'La recette n\'a pas été trouvée.');
            return $this->redirectToRoute('tcb_front_recipe_getAll');
        }

        $this->denyAccessUnlessGranted('RECIPE_MODIF', $recipe);

        $entityManager->remove($recipe);
        $entityManager->flush();

        $this->addFlash(
            'danger',
            "La recette a bien été supprimée !"
        );

        /** @var \App\Entity\User */
        $user = $security->getUser();
        $referer = $request->headers->get("referer") ?: $this->generateUrl('tcb_front_user_getRecipesByUserLog', ['slug' => $user->getSlug()]);
        
        return $this->redirect($referer);
    }

    /**
     * @Route("/recipe/{slug}", name="tcb_front_recipe_show")
     */
    public function show(Recipe $recipe, UserRepository $userRepository, $slug): Response
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->findOneBy(['slug' => $slug]);
        $user = $userRepository->findAll();

        return $this->render('Front/recipe/show.html.twig', [
            'recipe' => $recipe,
            'user' => $user
        ]);
    }
}