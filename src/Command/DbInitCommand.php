<?php

namespace App\Command;

use App\Entity\User;
use App\Services\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DbInitCommand extends Command
{
    protected static $defaultName = 'app:db:init';

    private const OPTION_ADMIN_EMAIL_TITLE = 'admin-email';
    private const OPTION_ADMIN_EMAIL_PASSWORD = 'admin-password';

    private $userService;

    public function __construct(UserService $userService, string $name = null)
    {
        $this->userService = $userService;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Create based db records')
            ->addOption(self::OPTION_ADMIN_EMAIL_TITLE, null, InputOption::VALUE_REQUIRED, 'Su-admin email')
            ->addOption(self::OPTION_ADMIN_EMAIL_PASSWORD, null, InputOption::VALUE_REQUIRED, 'Su-admin password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $adminEmail = $input->getOption(self::OPTION_ADMIN_EMAIL_TITLE);
        $adminPassword = $input->getOption(self::OPTION_ADMIN_EMAIL_PASSWORD);

        if (empty($adminEmail) || empty($adminPassword)) {
            $io->error('Su-admin email or password not set. Use options --' . self::OPTION_ADMIN_EMAIL_TITLE . ' and --' . self::OPTION_ADMIN_EMAIL_PASSWORD);

            return 1;
        }

        $this->userService->createUser($adminEmail, $adminPassword, [User::ROLE_SUPER_ADMIN], true);

        $io->success('Success!');

        return 0;
    }
}
