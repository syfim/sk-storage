<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends EasyAdminController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     */
    protected function persistUserEntity(User $user)
    {
        $encodedPassword = $this->encodePassword($user, $user->getPlainPassword());

        if (null != $encodedPassword) {
            $user->setPassword($encodedPassword);
        }

        parent::persistEntity($user);
    }

    /**
     * @param User $user
     */
    protected function updateUserEntity(User $user)
    {
        $encodedPassword = $this->encodePassword($user, $user->getPlainPassword());

        if (null != $encodedPassword) {
            $user->setPassword($encodedPassword);
        }

        parent::updateEntity($user);
    }

    private function encodePassword(User $user, ?string $plainPassword): ?string
    {
        if (empty($plainPassword)) {
            return null;
        }

        return $this->passwordEncoder->encodePassword($user, $plainPassword);
    }
}