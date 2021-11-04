<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatasGenerateCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected static $defaultName = 'app:datas:generate';
    protected static $defaultDescription = 'Generate data of an sql + load fixtures';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $toto = file_get_contents(__DIR__ . '/../../oldix.sql');
        } catch (\Throwable $th) {
            $io->error('Check that you have a "oldix.sql" file on the project root');
            return Command::FAILURE;
        }

        $rsm = new ResultSetMapping();
        $query = $this->em->createNativeQuery($toto, $rsm);
        try {
            $query->execute();
        } catch (\Throwable $th) {
            if ($th->getMessage() === 'Notice: Undefined offset: 1') {
                $io->success('Import successful !');
                $io->info('Loading fixtures...');
                $command = $this->getApplication()->find('doctrine:fixtures:load');
                $arguments = [
                    '--append' => true
                ];
                $fixtureInput = new ArrayInput($arguments);
                try {
                    $command->run($fixtureInput, $output);
                } catch (\Throwable $th) {
                    $io->error('There is a issue on your fixtures');
                    return Command::FAILURE;
                }

                $io->success('Fixtures loaded, you can use the database !');
                return Command::SUCCESS;
            } else {
                $io->error($th->getMessage());
                return Command::FAILURE;
            }
        }
    }
}
