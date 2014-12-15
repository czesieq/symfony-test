<?php
/**
 * Created by PhpStorm.
 * User: Czesieq
 * Date: 2014-12-13
 * Time: 12:25
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller{


    /**
     * @param $request Request object
     * @return Response
     */
    public function loginAction(Request $request){
        $session = $request->getSession();

        if($request->attributes->has(Security::AUTHENTICATION_ERROR)){
            $error = $request->attributes->get(
                Security::AUTHENTICATION_ERROR
            );
        }elseif( null !== $session && $session->has(Security::AUTHENTICATION_ERROR)){
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }else{
            $error = '';
        }

        if($session === null){
            $lastUsername = '';
        }else{
            $lastUsername = $session->get(Security::LAST_USERNAME);
        }

        return $this->render(
            'AppBundle:Security:login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );

    }

} 