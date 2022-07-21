<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/{cat_alias}/{article_alias}_{id}", name="show_article", methods={"GET"})
     */
    public function showArticle(Article $article): Response
    {
        return $this->render("article/show_article.html.twig", [
            'article' => $article
        ]);
    } # end function showArticle()

    /**
     * @Route("/voir-articles/{alias}", name="show_articles_from_category", methods={"GET"})
     */
    public function showArticlesFromCategory(Category $category, EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)
            ->findBy([
                'category' => $category->getId(),
                'deletedAt' => null
            ]);

        return $this->render("article/show_articles_from_category.html.twig", [
            'articles' => $articles,
            'category' => $category
        ]);
    }


} # end class