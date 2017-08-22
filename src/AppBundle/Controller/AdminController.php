<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
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
     * Lists all user entities.
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
     * Lists all user entities.
     *
     * @Route("/home", name="admin_home")
     *
     */
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();
        // rend la vue
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


}
