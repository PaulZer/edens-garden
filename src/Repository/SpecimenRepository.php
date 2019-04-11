<?php

namespace App\Repository;

use App\Entity\Garden\Specimen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Specimen|null find($id, $lockMode = null, $lockVersion = null)
 * @method Specimen|null findOneBy(array $criteria, array $orderBy = null)
 * @method Specimen[]    findAll()
 * @method Specimen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecimenRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Specimen::class);
    }

    private function getEfficiencyByType(string $type, string $plant_id, string $type_id)
    {
        $conn = $this->getEntityManager()->getConnection();

        switch ($type) {
            case "plant_soil_type" :
                $sql = "Select efficiency from " . $type . " where plant_id=:plant_id and soil_type_id=:soil_type_id";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['plant_id' => $plant_id, 'soil_type_id' => $type_id]);
                break;
            case "plant_sun_exposure_type":
                $sql = "Select efficiency from " . $type . " where plant_id=:plant_id and sun_exposure_type_id=:sun_exposure_type_id";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['plant_id' => $plant_id, 'sun_exposure_type_id' => $type_id]);
                break;
            case "plant_fertilizer_type":
                $sql = "Select efficiency from " . $type . " where plant_id=:plant_id and fertilizer_type_id=:fertilizer_type_id";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['plant_id' => $plant_id, 'fertilizer_type_id' => $type_id]);
                break;
        }
        return $stmt->fetch();
    }

    public function getSpecimenSoilTypeEfficiency(Specimen $specimen)
    {
        $plotSoilType = $specimen->getPlot()->getSoilType();
        $plantPreferedSoilType = $specimen->getPlant()->getPreferedSoilTypes();
        foreach ($plantPreferedSoilType as $soilType) {
            if ($plotSoilType == $soilType->getSoilType()) {
                return $this->getEfficiencyByType("plant_soil_type", $specimen->getPlant()->getId(), $soilType->getSoilType()->getId())["efficiency"];
            }
        }
        return 0;
    }

    public function getSpecimenSunExposureTypeEfficiency(Specimen $specimen)
    {
        $plotSunExposureType = $specimen->getPlot()->getSunExposureType();
        $plantPreferedSunExposureType = $specimen->getPlant()->getPreferedSunExposureTypes();
        foreach ($plantPreferedSunExposureType as $sunExposureType) {
            if ($plotSunExposureType == $sunExposureType->getSunExposureType()) {
                return $this->getEfficiencyByType("plant_sun_exposure_type", $specimen->getPlant()->getId(), $sunExposureType->getSunExposureType()->getId())["efficiency"];
            }
        }
        return 0;
    }

    public function getSpecimenFertilizerTypeEfficiency(Specimen $specimen)
    {
        $specimenFertilizer = $specimen->getFertilizer();
        $plantPreferedFertilizerType = $specimen->getPlant()->getPreferedFertilizerTypes();
        foreach ($plantPreferedFertilizerType as $fertilizerType) {
            if ($specimenFertilizer == $fertilizerType->getFertilizer()) {
                return $this->getEfficiencyByType("plant_fertilizer_type", $specimen->getPlant()->getId(), $fertilizerType->getFertilizer()->getId())["efficiency"];
            }
        }
        return 0;
    }

    public function getSpecimenCompatibilityWithEnvironment(Specimen $specimen)
    {
        $compatibility = ($this->getSpecimenFertilizerTypeEfficiency($specimen) + $this->getSpecimenSoilTypeEfficiency($specimen) + $this->getSpecimenSunExposureTypeEfficiency($specimen)) / 3;
        if ($compatibility < 25) {
            return 0;
        } elseif ($compatibility >= 25 && $compatibility < 50) {
            return 25;
        } elseif ($compatibility >= 50 && $compatibility < 75) {
            return 50;
        } elseif ($compatibility >= 75 && $compatibility < 100) {
            return 75;
        } else {
            return 100;
        }
    }
}
