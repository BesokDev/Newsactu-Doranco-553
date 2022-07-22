<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_home", methods={"GET"})
     */
    public function home(EntityManagerInterface $entityManager): Response
    {   # Exercice : Récupérer les articles non archivés et envoyer les à la vue twig
        $articles = $entityManager->getRepository(Article::class)->findBy(['deletedAt' => null]);

        return $this->render("default/home.html.twig", [
            'articles' => $articles
        ]);
    }
}