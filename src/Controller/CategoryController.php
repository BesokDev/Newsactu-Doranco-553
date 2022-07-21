<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/ajouter-une-categorie", name="create_category", methods={"GET|POST"})
     */
    public function createCategory(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $category->setAlias($slugger->slug($category->getName()));
            $category->setCreatedAt(new DateTime());
            $category->setUpdatedAt(new DateTime());

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', "La catégorie a bien été ajouté");
            return $this->redirectToRoute('show_dashboard');
        }

        return $this->render("admin/form/category.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifier-une-categorie/{id}", name="update_category", methods={"GET|POST"})
     */
    public function updateCategory(Category $category, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CategoryFormType::class, $category)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $category->setAlias($slugger->slug($category->getName()));
            $category->setUpdatedAt(new DateTime());

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', "La catégorie a bien été modifié");
            return $this->redirectToRoute('show_dashboard');
        }

        return $this->render("admin/form/category.html.twig", [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }

    /**
     * @Route("/archiver-une-categorie/{id}", name="soft_delete_category", methods={"GET"})
     */
    public function softDeleteCategory(Category $category, EntityManagerInterface $entityManager): RedirectResponse
    {
        $category->setDeletedAt(new DateTime());

        $entityManager->persist($category);
        $entityManager->flush();

        $this->addFlash('success', 'La catégorie a bien été archivé');
        return $this->redirectToRoute('show_dashboard');
    }

    /**
     * @Route("/restaurer-une-categorie/{id}", name="restore_category", methods={"GET"})
     */
    public function restoreCategory(Category $category, EntityManagerInterface $entityManager): RedirectResponse
    {
        $category->setDeletedAt(null);

        $entityManager->persist($category);
        $entityManager->flush();

        $this->addFlash('success', 'La catégorie a bien été restauré');
        return $this->redirectToRoute('show_dashboard');
    }

    /**
     * @Route("/supprimer-une-categorie/{id}", name="hard_delete_category", methods={"GET"})
     */
    public function hardDeleteCategory(Category $category, EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('success', 'La catégorie a bien été supprimé définitivement de la base');
        return $this->redirectToRoute('show_dashboard');
    }

} # end class