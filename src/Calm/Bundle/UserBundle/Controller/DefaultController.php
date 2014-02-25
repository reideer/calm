<?php

namespace Calm\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/helloaa/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        $name = $name."teste";
        return array('name' => $name."Calmo Bundle");
    }
}
