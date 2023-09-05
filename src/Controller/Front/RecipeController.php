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
                             UserRepository $users, 
                             PaginatorInterface $paginator, 
                             Request $request): Response
    {
        $recipes = $recipeRepository->findBy([],['created_at' => 'DESC']);

        $recipes = $paginator->paginate(
            $recipes, // = my datas
            $request->query->getInt('page', 1), // = get page number in request url, and set page default to "1"
            10 // = limit by page
        );


        return $this->render('Front/recipe/list.html.twig', [
            'recipes' => $recipes,
            'users' => $users
        ]);
    }

    /**
     * @Route("/recipe/query", name="tcb_front_recipe_search")
     */
    public function search(RecipeRepository $recipeRepository, Request $request): Response
    {
        $recipes = $recipeRepository->searchRecipe($request->get("search"));

        // dd($recipes);

        return $this->render('Front/recipe/search.html.twig', [
            'recipes' => $recipes,
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

        // dd($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageCloudUrl =  $request->get("cloudinaryUrl");
            $recipe->setPicture($imageCloudUrl);
            
            $entityManager->persist($recipe);
            $entityManager->flush();

            // ! flash message to add
            $this->addFlash("success", "La recette a été modifiée.");

            //dd($slug);
            
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

        // dd($recipe);
        return $this->render('Front/recipe/show.html.twig', [
            'recipe' => $recipe,
            'user' => $user
        ]);
    }
}