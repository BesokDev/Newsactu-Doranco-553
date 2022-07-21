<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RenderController extends AbstractController
{
    /**
     * @Route("/categories", name="render_categories_in_nav")
     */
    public function renderCategoriesInNav(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Category::class)->findBy(['deletedAt' => null]);

        return $this->render('rendered/categories_in_nav.html.twig', [
            'categories' => $categories
        ]);
    }
}