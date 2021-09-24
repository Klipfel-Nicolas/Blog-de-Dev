<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleReview;
use App\Form\ArticleReviewType;
use App\Repository\ArticleReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/article/review", name="article_review_")
 */
class ArticleReviewController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ArticleReviewRepository $articleReviewRepository): Response
    {
        return $this->render('article_review/index.html.twig', [
            'article_reviews' => $articleReviewRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{slug}", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, string $slug): Response
    {
        if(!$this->getUser()) return $this->redirectToRoute('home');

        $articleReview = new ArticleReview();
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy(['slug' => $slug]);
        $form = $this->createForm(ArticleReviewType::class, $articleReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $articleReview  ->setAuthor($this->getUser()->getFirstName())
                            ->setArticle($article);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articleReview);
            $entityManager->flush();

            return $this->redirectToRoute('blog_article_show', [
                'slug' => $article->getSlug()
            ]);
        }

        return $this->renderForm('article_review/new.html.twig', [
            'article_review' => $articleReview,
            'form' => $form,
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(ArticleReview $articleReview): Response
    {
        return $this->render('article_review/show.html.twig', [
            'article_review' => $articleReview,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ArticleReview $articleReview): Response
    {
        $form = $this->createForm(ArticleReviewType::class, $articleReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_review_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article_review/edit.html.twig', [
            'article_review' => $articleReview,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, ArticleReview $articleReview): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articleReview->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($articleReview);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_review_index', [], Response::HTTP_SEE_OTHER);
    }
}
