<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/blog")
 */
class BlogController extends Controller
{
    /**
     * @Route("/", name="blog")
     */
    public function index()
    {
        $depot = $this->getDoctrine()->getRepository(Article::class);
        $articles = $depot->findBy(array(), array('date' => 'DESC'), 3, 0);

        return $this->render('blog/blog_main.html.twig',
            array(
                "articles" => $articles,
                'controller_name' => 'Space-Blog'
            )
        );

    }

    /**
     * @Route("/article/{id}", name="article", requirements={"id ": "\d+"})
     */
    public function article($id, Request $request)
    {
        # Get article
        $depot = $this->getDoctrine()->getRepository(Article::class);
        $article = $depot->find($id);
        if (!$article) {
            throw $this->createNotFoundException('L\'article n°' . $id . ' n\'existe pas !');
        }
        # Add Comment
        $comment = new Comment();

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY') ||
            $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $userName = $this->getUser()->getUsername();
            $comment->setAuthor($userName);
        }

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setArticle($article);
            $gestionnaire = $this->getDoctrine()->getManager();
            $gestionnaire->persist($comment);
            $gestionnaire->flush();

            return $this->redirectToRoute('article', array("id" => $id));
        }


        return $this->render('blog/blog_main.html.twig', array("article" => $article, 'form' => $form->createView()));

    }

    /**
     * @Route("/add", name="add_article")
     * @Security ("has_role ('ROLE_REDAC')")
     */
    public function addArticle(Request $request)
    {
        $article = new Article();
        $userName = $this->getUser()->getUsername();
        $article->setAuthor($userName);

        $form =$this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $gestionnaire =$this->getDoctrine()->getManager();
            $gestionnaire->persist($article);

            # Abstract -> if empty, 10 first words of body
            if(empty($article->getAbstract()))
            {
                $article->setAbstract((implode(' ', array_slice(explode(' ', $article->getBody()), 0, 10))));
            }

            $gestionnaire->flush();
            return $this->redirectToRoute('article', array('id' => $article->getId()));

        } else {
            return $this->render('blog/add_article.html.twig',
                array('form' => $form->createView()));
        }
    }
    /**
     * @Route("/articles", name="articles")
     */
    public function displayArticles()
    {
        $depot = $this->getDoctrine()->getRepository(Article::class);
        $articles = $depot->findAll();

        // Script pour créer les abstract des articles si insérés avec generateData
        /*foreach ($articles as $article){
            $article->setAbstract();
            $gestionnaire = $this->getDoctrine()->getManager();
            $gestionnaire->persist($article);
            $gestionnaire->flush();
        }*/

        return $this->render('blog/blog_main.html.twig', array("articles" => $articles));
    }
}
