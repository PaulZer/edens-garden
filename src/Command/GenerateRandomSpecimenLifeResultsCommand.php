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
        $now = new \DateTimeImmutable('now');
        $now = $now->modify('-11 day');
        for ($i = 1; $i <= 10; $i++){
            $dates[] = $now->modify('+'.$i.' day');
        }

        foreach ($dates as $date) {
            foreach ($specimens as $specimen){
                if($date->getTimeStamp() >= $specimen->getPlantationDate()->getTimeStamp()){
                    $specWaterFrequency = $specimen->getPlant()->getWaterFrequency();
                    if(random_int(0, 1000)/1000 > 1/$specWaterFrequency){
                        echo "waterize\n";
                        $this->specService->waterize($specimen->getId(), random_int(0, 1), $date);
                    }
                    if($specimen->getFertilizer() == null){
                        if(random_int(0, 1)){
                            $fertilizer = $this->manager->getRepository("App\Entity\Plant\FertilizerType")->findOneBy([
                                'code' => $this->fertilizerTypes[array_rand($this->fertilizerTypes)]
                            ]);
                            $specimen->setFertilizer($fertilizer);

                            echo "fertilize\n";
                            $this->specService->fertilize($specimen->getId(), $date);
                        }
                    }
                }
            }
            $this->specService->dailyLifeResultForAllSpecimen($date);
        }
        exit;
    }
}