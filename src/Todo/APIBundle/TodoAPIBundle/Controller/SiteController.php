<?php

namespace Todo\APIBundle\TodoAPIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class SiteController extends Controller {

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        $x = 1;
    }
}