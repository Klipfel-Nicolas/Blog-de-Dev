<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\RessourceRepository;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/index", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/index.html.twig');
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(ArticleRepository $articles): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $articles = $articles->findAll();
            
            return $this->render('admin/article/admin_index.html.twig', [
                'articles' => $articles
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/ressources", name="ressources")
     */
    public function ressource(RessourceRepository $ressources): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $ressources = $ressources->findAll();
            return $this->render('admin/ressource/admin_index.html.twig', [
                'ressources' => $ressources
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/tags", name="tags")
     */
    public function tag(TagRepository $tags): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $tags = $tags->findAll();
            return $this->render('admin/tag/admin_index.html.twig', [
                'tags' => $tags
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }
}