<?php

namespace App\Command;

use App\DataFixtures\AppFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class TcbFixtureCommand extends Command
{
    protected static $defaultName = 'tcb:fixture';
    protected static $defaultDescription = 'Add a short description for your command';

    private $passwordHasher;
    private $slugger;
    private $entityManager;

    public function __construct(SluggerInterface $slugger,
                                UserPasswordHasherInterface $passwordHasher, 
                                EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->slugger = $slugger;
        $this->entityManager = $entityManager;

        // ! il est important d'appeler le constructeur du parent sinon la commande ne marchera plus car il contient de la logique necessaire
        parent::__construct();
    }

    protected function configure()
        {
            $this->setDescription('Load production fixtures')
                 ->setHelp('This command loads production fixtures.');
        }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Purge the database to remove existing data if necessary
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();

        // $em = $this->entityManager;
        // $metaData = $em->getMetadataFactory()->getAllMetadata();

        // $tool = new SchemaTool($em);
        // $tool->dropSchema($metaData);
        // $tool->createSchema($metaData);

        // Load your production fixtures
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute([new AppFixtures($this->slugger, $this->passwordHasher)]);

        $output->writeln('Fixture bien envoyée en bdd.');

        return Command::SUCCESS;
    }
}
