<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AccountRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param AccountRepository $accountRepository
     * @return Response
     */
    public function index(AccountRepository $accountRepository, ProjectRepository $projectRepository)
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user->hasRole(User::ROLE_ADMIN) || $user->hasRole(User::ROLE_SUPER_ADMIN)) {
            $projects = $projectRepository->findAllWithAccounts();
        } else {
            $projects = $projectRepository->findByUser($this->getUser());
        }

        return $this->render('homepage/index.html.twig', [
            'projects' => $projects
        ]);
    }
}
