<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Entity\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{


    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    public function testAction(){

        $em = $this->getDoctrine()->getManager();


        $role = new Role();
        $role->setName('Admin');
        $role->setRole('ROLE_ADMIN');

        $em->persist($role);
        $em->flush();

        $user = new User();
        $password = 'secret';
        $encoded = $this->container->get('security.password_encoder')
            ->encodePassword($user, $password);

        $user->setPassword($encoded);
        $user->setEmail('admin@domain.com');
        $user->setUsername('admin');
        $user->setIsActive(true);
        $user->addRole($role);

        $em->persist($user);
        $em->flush();


        echo($user->getId());



        echo($encoded);

        return $this->render('default/index.html.twig');
    }
}
