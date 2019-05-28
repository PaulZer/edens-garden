<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 06/05/2019
 * Time: 11:02
 */

namespace App\Command;

use App\Repository\SpecimenRepository;
use App\Service\SpecimenService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DailyGardenFeedBackCommand extends Command
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


    protected static $defaultName = 'app:daily_garden_feedback';

    protected function configure()
    {
        $this
            ->setDescription('Send notification to user if needed')
            ->setHelp('Just set a cron firing this command, daily :  php bin/console app:daily_garden_feedback');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->specService->dailyGardenFeedback();

    }
}