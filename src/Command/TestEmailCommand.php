<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'TestEmail',
    description: 'Add a short description for your command',
)]
class TestEmailCommand extends Command
{
    public function __construct(
        private readonly MailerInterface $mailer
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);

        $email = (new Email())
            ->from('no-reply@ongkagninmin.com')
            ->to('test@localhost.com')
            ->subject('Test Mailpit')
            ->text('Ceci est un test');

        $this->mailer->send($email);

        $io->success('Email envoyé !');

        return Command::SUCCESS;
    }
}
