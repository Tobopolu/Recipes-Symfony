<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController {
    #[Route('/', name: 'index')]
    public function index(
        RecipeRepository $recipeRepository
    )
    : Response {

        return $this->render(
            'recipe/index.html.twig',
            [
                'recipes' => $recipeRepository->findAll(),
            ]
        );
    }

    #[Route('/recipe/{id}', name: 'recipe.show')]
    public function show(RecipeRepository $recipeRepository, $id): Response
    {
        $recipe = $recipeRepository->find($id);

        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }


    // #[Route('/new', name: 'recipe_new')]
    // public function create(): Response
    // {
    //     return $this->render('recipe/create.html.twig', [
    //         'title' => "Create a new recipe",
    //     ]);
    // }
    #[Route('/new', name: 'recipe_new')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        if ($request->isMethod('POST')) {
        // Récupère les données du formulaire
        $title = $request->request->get('title');
        $recipe = $request->request->get('recipe');
        $ingredients = $request->request->get('ingredients');
        $instructions = $request->request->get('instructions');
        $prep_time = $request->request->get('prep_time');
        $cook_time = $request->request->get('cook_time');
        $difficulty = $request->request->get('difficulty');
        $image = $request->request->get('image');

        // Crée une nouvelle instance de Recipe avec les arguments
        $newRecipe = new Recipe($recipe, $title, $ingredients, $image, $instructions, $prep_time, $cook_time, $difficulty);

        // Persiste la recette dans la base de données
        $entityManager->persist($newRecipe);
        $entityManager->flush();

        // Redirige l'utilisateur vers la page d'accueil
        return $this->redirectToRoute('index');
        }

        return $this->render('recipe/create.html.twig', [
            'title' => "Create a new recipe",
        ]);

    }


    #[Route('/delete/{id}', name: 'recipe_delete')]
    public function delete($id, RecipeRepository $recipeRepository): Response {
        $recipe = $recipeRepository->find($id);
    
        return $this->render('recipe/delete.html.twig', [
            'recipe' => $recipe
        ]);
    }

    #[Route('/delete/confirm/{id}', name: 'recipe_delete_confirm', methods: ['POST'])]
    public function confirmDelete($id, RecipeRepository $recipeRepository, EntityManagerInterface $entityManager): Response {
        $recipe = $recipeRepository->find($id);

        $entityManager->remove($recipe);
        $entityManager->flush();

        $this->addFlash('success', 'Recette supprimée avec succès !');
        return $this->redirectToRoute('index');
    }

    
 

}