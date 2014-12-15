<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{

    /**
     * Display the default view for the dashboard
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){
        $data = [];

        $session = $request->getSession();

        $data['username'] = $this->getUser()->getUsername();
        $data['messages']['success'] = $session->getFlashBag()->get('success',[]);
        $data['messages']['info'] = $session->getFlashBag()->get('info',[]);
        $data['messages']['warning'] = $session->getFlashBag()->get('warning',[]);
        $data['messages']['danger'] = $session->getFlashBag()->get('danger',[]);
        $data['articles'] = $this->getArticles();

        return $this->render(
            'AppBundle:Dashboard:list.html.twig', $data
        );

    }


    private function getArticles(){
        $articles = $this->getDoctrine()
            ->getRepository('AppBundle:Article')
            ->findAll();

        return $articles;
    }

}
