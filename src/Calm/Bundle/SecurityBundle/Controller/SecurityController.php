<?php

namespace Calm\Bundle\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller {

    /**
     * @Route("/login", name="login")
     * @Template()
     *
     */
    public function loginAction() {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('_default'));
        }
        
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                    SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
                        'CalmSecurityBundle:Security:login.html.twig', array(
                    // last username entered by the user
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
                        )
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction() {
        
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutCheckAction() {
        
    }

}