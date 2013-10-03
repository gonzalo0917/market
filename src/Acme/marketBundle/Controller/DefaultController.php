<?php

namespace Acme\marketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AcmemarketBundle:Default:index.html.twig');
    }
}
