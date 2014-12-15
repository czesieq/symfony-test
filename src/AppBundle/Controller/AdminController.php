<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller{


    /**
     * @Route("/admin")
     */
    public function dashboardAction(){
        echo("This is the admin action");

    }


} 