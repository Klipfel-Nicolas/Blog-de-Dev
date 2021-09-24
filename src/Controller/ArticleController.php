<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\ArticleLikes;
use App\Form\SearchType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleLikesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/blog", name="blog_")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return Response
     * @param PaginatorInterface $paginator
     */
    public function index(ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);

        $article = $paginator->paginate(
           $articleRepository->findSearch($data),
           $request->query->getInt('page', $data->page),
           5
        );
         

        return $this->render('article/index.html.twig', [
            'articles' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     * @param Request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{slug}", name="article_show", methods={"GET"})
     * @param Article
     * @return Response
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Permet de liker ou unliker un article
     *
     * @Route("/{slug}/like", name="article_like")
     * 
     * @param Article $article
     * @param ObjectManager $manager
     * @param ArticleLikeRepository $repository
     * @return Response
     */
    public function like(Article $article, EntityManagerInterface $manager, ArticleLikesRepository $likeRepo ): Response
    {
        $user = $this->getUser();

        //Si non connecter
        if(!$user) return $this->json([
            'code' => 403,
            'message' => 'Unauthorized'
        ], 403);

        //Enlever un like
        if($article->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy([
                'article' => $article,
                'user' => $user
            ]);

            $manager->remove(($like));
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'like supprimer',
                'likes' => $likeRepo->count(['article' => $article])
            ], 200);
        }

        //liker
        $like = new ArticleLikes();
        $like   ->setArticle($article)
                ->setUser($user);

        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'like ajouter',
            'likes' => $likeRepo->count(['article' => $article])
        ], 200);
    }

}
