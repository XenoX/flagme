<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Add user on database',
)]
class CreateUserCommand extends Command
{
    public function __construct(private UserPasswordHasherInterface $hasher, private EntityManagerInterface $manager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');

        $user = new User();
        $user
            ->setUsername($username)
            ->setPassword($this->hasher->hashPassword($user, 'changeme'))
            ->setRoles(['ROLE_ADMIN'])
        ;

        $this->manager->persist($user);
        $this->manager->flush();

        $io->success(sprintf('User %s created.', $username));

        return Command::SUCCESS;
    }
}
