<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 06/05/2019
 * Time: 11:23
 */

namespace App\Command;

use App\Repository\SpecimenRepository;
use App\Service\SpecimenService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HourlyWeatherResultCommand extends Command
{
    private $specRepo;
    private $specService;
    private $manager;

    public function __construct(SpecimenRepository $specRepo, SpecimenService $specService, ObjectManager $manager)
    {
        $this->specRepo = $specRepo;
        $this->specService = $specService;
        $this->manager = $manager;

        parent::__construct();
    }


    protected static $defaultName = 'app:hourly_weather_result';

    protected function configure()
    {
        $this
            ->setDescription('If it rain a lot it will waterize the specimen')
            ->setHelp('Just set a chron each hours with this command  :  php bin/console app:hourly_weather_result');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      $this->specService->allSpecimensHourlyWeatherResult();
    }
}