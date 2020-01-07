<?php


namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    private $passwordEncoder;
    private $validator;
    private $em;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
        $this->em = $entityManager;
    }

    public function createUser(string $email, string $plainPassword, array $roles, $withFlush = false)
    {
        $user = new User();
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $plainPassword));

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors[0]->getMessage());
        }

        $this->em->persist($user);

        if ($withFlush) {
            $this->em->flush();
        }

        return $user;
    }
}