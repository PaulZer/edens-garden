<?php


namespace App\Command;

use App\Repository\SpecimenRepository;
use App\Service\SpecimenService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class GenerateRandomSpecimenLifeResultsCommand extends Command
{
    private $specRepo;
    private $specService;
    private $manager;
    private $fertilizerTypes = ['N', 'K', 'P', 'N-K', 'N-P', 'K-P'];

    public function __construct(SpecimenRepository $specRepo, SpecimenService $specService, ObjectManager $manager)
    {
        $this->specRepo = $specRepo;
        $this->specService = $specService;
        $this->manager = $manager;

        parent::__construct();
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:generate_random_life_results';

    protected function configure()
    {
        $this
            ->setDescription('Generates for the 10 last days random conditions and logs all the specimens life results during those days')
            ->setHelp('Load fixtures, then run php bin/console app:generate_random_life_results')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $specimens = $this->specRepo->findAll();

        $this->specService->generateRandomLifeResults($specimens);
    }
}