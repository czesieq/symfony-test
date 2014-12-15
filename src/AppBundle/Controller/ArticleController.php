<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Article;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Entity\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{

    public function createAction(Request $request){
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->getForm();

        if($request->getMethod() == "POST"){
            $form->bind($request);

            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl('dashboard'));
            }
        }

        return $this->render('AppBundle:Article:create.html.twig',
            ['form' => $form->createView()]);
    }


    public function toggleAction(Request $request, $id){
        $article = $this->loadArticleById($id);

        if($article->getIsActive()){
            $article->setIsActive(0);
        }else{
            $article->setIsActive(1);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($article);
        $em->flush();

        return $this->redirect($this->generateUrl('dashboard'));
    }


    public function editAction(Request $request, $id){
        $article = $this->loadArticleById($id);

        $form = $this->createFormBuilder($article)
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->getForm();

        if($request->getMethod() == "POST"){
            $form->bind($request);

            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl('dashboard'));
            }
        }

        return $this->render('AppBundle:Article:create.html.twig',
            ['form' => $form->createView()]);
    }

    private function loadArticleById($id){
        $article = $this->getDoctrine()
            ->getRepository('AppBundle:Article')
            ->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        }

        return $article;
    }

    public function deleteAction(Request $request, $id){
        $article = $this->loadArticleById($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->redirect($this->generateUrl('dashboard'));
    }
}
