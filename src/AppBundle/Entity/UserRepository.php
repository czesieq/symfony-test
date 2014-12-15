<?php
/**
 * Created by PhpStorm.
 * User: Czesieq
 * Date: 2014-12-13
 * Time: 13:10
 */

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository implements UserProviderInterface{

    public function loadUserByUsername($username){
        $query = $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery();

        try{
            $user = $query->getSingleResult();
        }catch (NoResultException $baseException){
            $message = sprintf(
                'Unable to find active admin object identified by "%s"',
                $username
            );
            throw new UsernameNotFoundException($message, 0 , $baseException);
        }
    }

    public function refreshUser(UserInterface $user){
        $class = get_class($user);
        if(!$this->supportsClass($class)){
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported', $class)
            );
        }

        return $this->find($user->getId());
    }

    public function supportsClass($class){
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }

} 