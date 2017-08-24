<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Article;
use AppBundle\Entity\Commentary;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{

    /**
     * Login Admin
     *
     * @Route("/", name="admin")
     *
     */
    public function indexAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError('mauvais identifiants');

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/admin.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * Admin Area
     *
     * @Route("/home", name="admin_home")
     *
     */
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('admin/index.html.twig', array(
            'users' => $users,

        ));

    }

    /**
     * Promote an user
     *
     * @Route("/promote/{id}", name="promote")
     * @Method({"GET", "POST"})
     */
    public function promoteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        $users = $em->getRepository('AppBundle:User')->findAll();

        $user->setRoles('ROLE_AUTHOR');
        $em->flush();

        return $this->render('admin/index.html.twig', array(
            'users' => $users,

        ));


    }

    /**
     * Demote an user
     *
     * @Route("/demote/{id}", name="demote")
     * @Method({"GET", "POST"})
     */
    public function demoteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        $users = $em->getRepository('AppBundle:User')->findAll();
        $user->getRoles();

        $user->setRoles('ROLE_USER');
        $em->flush();

        return $this->render('admin/index.html.twig', array(
            'users' => $users,

        ));


    }


    /**
     * Lists all user's Article
     *
     * @Route("/show/{id}", name="articles_user")
     * @Method("GET")
     */
    public function getAllUserArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);



        $articles = $em->getRepository('AppBundle:Article')->findBy(
            array('user' => $user)
        );

        return $this->render('admin/article.html.twig', array(
            'articles' => $articles,

        ));
    }

    /**
     * Deletes a article entity.
     *
     * @Route("/test/{id}", name="admin_delete")
     * @Method("GET")
     */
    public function deletesAction($id)
    {
        $commentary = new Commentary();

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);
        $commentary = $em->getRepository('AppBundle:Commentary')->find($id);
        if($commentary){
            $em->remove($commentary);
        }

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('admin_home');
    }

}
