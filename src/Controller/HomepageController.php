<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use App\Repository\AccountRepository;
use App\Repository\MonitoringTaskRepository;
use App\Repository\ProjectRepository;
use App\Services\MonitoringService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param ProjectRepository $projectRepository
     * @return Response
     */
    public function index(ProjectRepository $projectRepository)
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user->hasRole(User::ROLE_ADMIN) || $user->hasRole(User::ROLE_SUPER_ADMIN)) {
            $projects = $projectRepository->findAllWithAccounts();
        } else {
            $projects = $projectRepository->findByUser($this->getUser());
        }

        if (!empty($projects)) {
            return $this->redirectToRoute('project_details', ['id' => $projects[0]->getId()]);
        }

        return $this->render('homepage/index.html.twig', [
            'projects' => $projects,
            'currentProject' => null
        ]);
    }

    /**
     * @Route("/project/{id}", name="project_details")
     * @param Project $project
     * @param ProjectRepository $projectRepository
     * @return Response
     */
    public function details(Project $project, ProjectRepository $projectRepository)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$project->userHaveAccessToProject($user)) {
            throw new AccessDeniedException();
        }

        if ($user->hasRole(User::ROLE_ADMIN) || $user->hasRole(User::ROLE_SUPER_ADMIN)) {
            $projects = $projectRepository->findAllWithAccounts();
        } else {
            $projects = $projectRepository->findByUser($this->getUser());
        }

        return $this->render('homepage/index.html.twig', [
            'projects' => $projects,
            'currentProject' => $project
        ]);
    }
}
