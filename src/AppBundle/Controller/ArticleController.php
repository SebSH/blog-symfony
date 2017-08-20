<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Commentary;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Article controller.
 *
 * @Route("article")
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/", name="article_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')->findAll();

        return $this->render('article/index.html.twig', array(
            'articles' => $articles,

        ));
    }

    /**
     * Lists all article entities.
     *
     * @Route("/user_article", name="article_user")
     * @Method("GET")
     */
    public function getAllUserArticleAction()
    {

        $currentUserUsername = $this->get('security.token_storage')->getToken()->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')->findBy(
            array('user' => $currentUserUsername)
        );

        return $this->render('article/user.html.twig', array(
            'articles' => $articles,

        ));
    }

    /**
     * Creates a new article entity.
     *
     * @Route("/new", name="article_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        //$entity =  $this->get('security.token_storage')->getToken()->getUser()->getUsername();

        $article = new Article();
        $article->setUser($this->get('security.token_storage')->getToken()->getUser());

        /*$user->setUsername('user1');
        $article->getUser()->add($user);*/
        $form = $this->createForm('AppBundle\Form\ArticleType', $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            $this->addFlash(
                'notice',
                'Votre article a bien été publié !'
            );

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),

        ));
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/{id}", name="default_article")
     * @Method({"GET", "POST"})
     */
    public function showMainAction(Article $article, Request $request)
    {

        $commentary = new Commentary();
        $commentary->setArticle($article);
        $commentary->getArticle();


        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $currentUserUsername = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
        }
        else{
            $currentUserUsername = null;
        }

        $deleteForm = $this->createDeleteForm($article);

        $form = $this->createForm('AppBundle\Form\CommentaryType', $commentary );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($commentary);
                $em->flush();
        }

        return $this->render('article/main.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
            'currentUserUsername' => $currentUserUsername,
            'commentary' => $commentary,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a article entity.
     *
     * @Route("/new/{id}", name="article_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Article $article)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $currentUserUsername = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
        }
        else{
            $currentUserUsername = null;
        }
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('article/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
            'currentUserUsername' => $currentUserUsername
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     * @Route("/{id}/edit", name="article_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('AppBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_edit', array('id' => $article->getId()));
        }

        return $this->render('article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a article entity.
     *
     * @Route("/{id}", name="article_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
