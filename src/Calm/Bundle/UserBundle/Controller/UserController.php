<?php

namespace Calm\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Calm\Bundle\UserBundle\Form\UserType;
use Calm\Bundle\UserBundle\Entity\User;

/**
 * @Route("/register", name="_register")
 * 
 */
class UserController extends Controller {

    /**
     * @Route("/", name="_register_form")
     * @Template()
     */
    public function registerAction() {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('_default'));
        }
        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        return $this->render(
                        'CalmUserBundle:User:register.html.twig', array('form' => $form->createView())
        );
    }

    /**
     * @Route("/create/", name="_create")
     * @Template()
     */
    public function createAction() {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new UserType(), new User());

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {


                /* @var $user User */
                $user = $form->getData();
                $user->setUsername($user->getEmail());

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword(
                        $user->getPassword(), $user->getSalt()
                );
                $user->setPassword($password);


                $em->persist($user);
                $em->flush();


                return $this->redirect($this->generateUrl('_default'));
            }
        }
        return $this->render(
                        'CalmUserBundle:User:register.html.twig', array('form' => $form->createView())
        );
    }

    private

    function createUser(array $data) {
        $user = new User();

        $factory = $this->get('security.encoder_factory');

        $encoder = $factory->getEncoder($user);

        $password = $encoder->encodePassword(
                $data['password'], $user->getSalt()
        );




        $user->setUsername($data['email']);
        $user->setEmail($data['email']);
        $user->setPassword($password);



        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();
    }

}

