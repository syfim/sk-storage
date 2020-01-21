<?php

namespace App\Command;

use App\Repository\MonitoringTaskRepository;
use App\Services\MonitoringService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class MonitoringCheckAllCommand extends Command
{
    protected static $defaultName = 'app:monitoring:check-all';

    private $monitoringTaskRepository;
    private $monitoringService;

    public function __construct(
        MonitoringTaskRepository $monitoringTaskRepository,
        MonitoringService $monitoringService,
        string $name = null
    )
    {
        $this->monitoringTaskRepository = $monitoringTaskRepository;
        $this->monitoringService = $monitoringService;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Check all actual monitoring tasks')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tasks = $this->monitoringTaskRepository->findTasksForCheck();
        $this->monitoringService->checkMonitoringTasks($tasks, true);

        return 0;
    }
}
