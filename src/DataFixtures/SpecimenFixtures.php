<?php


namespace App\DataFixtures;


use App\Entity\Plant\FertilizerType;
use App\Entity\Plant\SoilType;
use App\Entity\Plant\SunExposureType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SpecimenFixtures extends Fixture
{
    private $manager = null;

    public function getFertilizerTypeByCode(string $code): FertilizerType
    {
        return $this->manager->getRepository("App\Entity\Plant\FertilizerType")->findOneBy(array('code' => $code));
    }

    public function getSunExposureTypeByCode(string $code): SunExposureType
    {
        return $this->manager->getRepository("App\Entity\Plant\SunExposureType")->findOneBy(array('code' => $code));
    }

    public function getSoilTypeByCode(string $code): SoilType
    {
        return $this->manager->getRepository("App\Entity\Plant\SoilType")->findOneBy(array('code' => $code));
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

       /* $garden = new Garden($this->getUserByEmail(''))

        $ps1 = new Specimen(
            $manager->getRepository("App\Entity\Plant\Plant")->findOneBy(['name' => 'Plant de tomate']),
            null,
            $this->getFertilizerTypeByCode( 'N-K'),
            new Plot('1', $this->getSunExposureTypeByCode('sun'), $this->getSoilTypeByCode('clay'), );
        );*/
    }
}