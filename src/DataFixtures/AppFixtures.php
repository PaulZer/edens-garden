<?php


namespace App\DataFixtures;


use App\Entity\Garden\Garden;
use App\Entity\Garden\Plot;
use App\Entity\Garden\Specimen;
use App\Entity\Plant\ClimaticArea;
use App\Entity\Plant\FertilizerType;
use App\Entity\Plant\LifeCycleStep;
use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantFamily;
use App\Entity\Plant\PlantFertilizerType;
use App\Entity\Plant\PlantingDateInterval;
use App\Entity\Plant\PlantLifeCycleStep;
use App\Entity\Plant\PlantSoilType;
use App\Entity\Plant\PlantSunExposureType;
use App\Entity\Plant\SoilType;
use App\Entity\Plant\SunExposureType;
use App\Entity\User;
use App\Entity\Util\Country;
use App\Entity\Util\Month;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $manager = null;
    private $userTest = null;

    private $tomato = null;

    protected function getPlantFamilyByCode($code): PlantFamily
    {
        return $this->manager->getRepository("App\Entity\Plant\PlantFamily")->findOneBy(array('code' => $code));
    }

    protected function getClimaticAreaByCode(string $code): ClimaticArea
    {
        return $this->manager->getRepository("App\Entity\Plant\ClimaticArea")->findOneBy(array('code' => $code));
    }

    protected function getSoilTypeByCode(string $code): SoilType
    {
        return $this->manager->getRepository("App\Entity\Plant\SoilType")->findOneBy(array('code' => $code));
    }

    protected function getSunExposureTypeByCode(string $code): SunExposureType
    {
        return $this->manager->getRepository("App\Entity\Plant\SunExposureType")->findOneBy(array('code' => $code));
    }

    protected function getFertilizerTypeByCode(string $code): FertilizerType
    {
        return $this->manager->getRepository("App\Entity\Plant\FertilizerType")->findOneBy(array('code' => $code));
    }

    protected function getLifeCycleStepByCode(string $code): LifeCycleStep
    {
        return $this->manager->getRepository("App\Entity\Plant\LifeCycleStep")->findOneBy(array('code' => $code));
    }

    protected function getPlantingDateIntervalByCode(string $climaticAreaCode, int $numMonthBegin, int $numMonthEnd): PlantingDateInterval
    {
        $monthBegin = $this->manager->getRepository("App\Entity\Util\Month")->findOneBy(array('num' => $numMonthBegin));
        $monthEnd = $this->manager->getRepository("App\Entity\Util\Month")->findOneBy(array('num' => $numMonthEnd));
        $climaticArea = $this->getClimaticAreaByCode($climaticAreaCode);

        $plantingDateInterval = $this->manager->getRepository("App\Entity\Plant\PlantingDateInterval")->findOneBy([
           'monthBegin' => $monthBegin,
           'monthEnd' => $monthEnd,
           'climaticArea' => $climaticArea
        ]);
        if(!$plantingDateInterval) return new PlantingDateInterval($monthBegin, $monthEnd, $climaticArea);
        else return $plantingDateInterval;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->loadMonths();

        $this->loadClimaticAreas();

        $this->loadCountries();

        $this->loadUsers();

        $this->loadPlantFamilies();

        $this->loadSunExposureTypes();

        $this->loadSoilTypes();

        $this->loadLifeCycleSteps();

        $this->loadFertilizerTypes();

        $this->loadPlants();

        $this->loadGardens();
    }

    protected function loadMonths(): bool
    {
        $months = [
            ['name' => 'Janvier', 'num' => 1],
            ['name' => 'Février', 'num' => 2],
            ['name' => 'Mars', 'num' => 3],
            ['name' => 'Avril', 'num' => 4],
            ['name' => 'Mai', 'num' => 5],
            ['name' => 'Juin', 'num' => 6],
            ['name' => 'Juillet', 'num' => 7],
            ['name' => 'Août', 'num' => 8],
            ['name' => 'Septembre', 'num' => 9],
            ['name' => 'Octobre', 'num' => 10],
            ['name' => 'Novembre', 'num' => 11],
            ['name' => 'Décembre', 'num' => 12],

        ];

        foreach ($months as $m){
            $month = new Month($m['name'], $m['num']);
            $this->manager->persist($month);
        }

        $this->manager->flush();

        return true;
    }

    protected function loadClimaticAreas(): bool
    {
        $climaticAreas = [
            ['name' => 'Nord de la France', 'code' => 'fra-n', 'maxLatitude' => 51.165673, 'minLatitude' => 47.997468],
            ['name' => 'Centre de la France', 'code' => 'fra-m', 'maxLatitude' => 47.997468, 'minLatitude' => 45.772231],
            ['name' => 'Sud de la France', 'code' => 'fra-s', 'maxLatitude' => 45.772231, 'minLatitude' => 42.342657],
        ];

        foreach ($climaticAreas as $ca) {
            $climaticArea = new ClimaticArea($ca['name'], $ca['code'], $ca['maxLatitude'], $ca['minLatitude']);
            $this->manager->persist($climaticArea);
        }

        $this->manager->flush();

        return true;
    }

    protected function loadCountries(): bool
    {
        //just France
        $countries = [
          ['name' => 'France', 'code' => 'fra']
        ];

        //countries are divided in 3 zones (north/middle/south)
        foreach ($countries as $c){
            $country = new Country(
                $c['name'],
                $c['code'],
                $this->getClimaticAreaByCode($c['code'].'-n'),
                $this->getClimaticAreaByCode($c['code'].'-m'),
                $this->getClimaticAreaByCode($c['code'].'-s')
            );

            $this->manager->persist($country);

            $this->manager->flush();

            return true;
        }
    }

    protected function loadUsers(): bool
    {
        $users = [
            ['firstName' => 'Paul', 'lastName' => 'Bouchillou', 'roles'=> ['ROLE_ADMIN'], 'email' => 'bouchilloupaul@gmail.com', 'password' => '$argon2i$v=19$m=1024,t=2,p=2$RVZ4NkoyNC53bkVES09yZg$q3LccGIDmDD9lug0b+rmhKhPEcMlkQl1Wo0uL5Te8ss'],
            ['firstName' => 'Matéo', 'lastName' => 'Rat', 'roles'=> ['ROLE_ADMIN'], 'email' => 'mateo.rat01@gmail.com', 'password' => '$argon2i$v=19$m=1024,t=2,p=2$Rm1nVmVlYzdSSVdIbGluMQ$TZrfT3uvay2KKTpTzjFhFT43uvBcYYIBNLzsVeAuXwM'],
            ['firstName' => 'Yoann', 'lastName' => 'Dufour', 'roles'=> ['ROLE_ADMIN'], 'email' => 'yoann01.d@gmail.com', 'password' => '$argon2i$v=19$m=1024,t=2,p=2$dVcyclpHamRHdHM1SnJpYg$R0Zo7zCBvn9EJT3njmuWNhpWG9NZd1i3FAeMJlrlCls'],
            ['firstName' => 'Elliot', 'lastName' => 'Edwards', 'roles'=> ['ROLE_ADMIN'], 'email' => 'elliot.edwards38@gmail.com', 'password' => '$argon2i$v=19$m=1024,t=2,p=2$SW1xNlhDSmtYZ2c1TDd6Qw$SYaqgchmD+uiZhjA4i1xqeYh4cxjaH6tv7Ua4LG5xhI'],
            /* mdp = user */['firstName' => 'User', 'lastName' => '2Test', 'roles'=> ['ROLE_USER'], 'email' => 'eden.garden.ptut@gmail.com', 'password' => '$argon2i$v=19$m=1024,t=2,p=2$Z1NVQTQ2WGw0OGhRWVo2Mg$ktPLwnKNcJBFy9tlBuc33Ze9W+movxiaQZTPdCkLKPA'],
        ];

        foreach ($users as $u){
            $user = new User();
            $user->setFirstName($u['firstName']);
            $user->setLastName($u['lastName']);
            $user->setRoles($u['roles']);
            $user->setEmail($u['email']);
            $user->setPassword($u['password']);
            $this->manager->persist($user);
            if($u['email'] === 'eden.garden.ptut@gmail.com') $this->userTest = $user;
        }

        $this->manager->flush();
        return true;
    }

    protected function loadPlantFamilies(): bool
    {
        $plantFamilies = [
            ['name' => 'Plantes à fruits', 'code' => 'fructable', 'description' => 'Plantes nécessitant une fructification optimale avant récolte des fruits.'],
            ['name' => 'Plantes comestibles', 'code' => 'eatable', 'description' => 'Plantes entièrement ou partiellement comestibles, atteignant une maturation avant d\'être entièrement récoltées.'],
            ['name' => 'Fleurs', 'code' => 'flower', 'description' => 'Les fleurs sont cultivées à but décoratif, elle doivent avoir une durée de vie longue à partir de la floraison.'],
            ['name' => 'Autre', 'code' => 'other', 'description' => 'Plantes n\'atteignant pas de floraison ou de fructification.'],
        ];

        foreach ($plantFamilies as $pf){
            $plantFamily = new PlantFamily($pf['name'], $pf['code'], $pf['description']);
            $this->manager->persist($plantFamily);
        }

        $this->manager->flush();

        return true;
    }

    protected function loadSunExposureTypes(): bool
    {
        $sunExposureTypes = [
            ['name' => 'Ensoleillée', 'code' => 'sun', 'description' => 'Il est préférable de faire pousser certaines plantes dans des milieux très ensoileillés, au moins 6 ou 8 heures par jour selon les espèces.'],
            ['name' => 'Semi-ensoleillée', 'code' => 'half-sun', 'description' => 'Un milieu semi-ensoleillé, ou semi-ombragé, convient très bien à une grande variété de plantes.'],
            ['name' => 'Ombragée', 'code' => 'shadow', 'description' => 'Une exposition ombragée est préférée de certaines expèces de plantes, qui en partie ne survivent pas bien trop longtemps exposées à la chaleur du soleil.'],
        ];

        foreach ($sunExposureTypes as $set){
            $sunExposureType = new SunExposureType($set['name'], $set['code'], $set['description']);
            $this->manager->persist($sunExposureType);
        }

        $this->manager->flush();

        return true;
    }

    protected function loadSoilTypes(): bool
    {
        $soilTypes = [
            ['name' => 'Terre argileuse', 'code' => 'clay', 'description' => 'La terre argileuse, formée de petites particules, est très compacte. Cette densité la rend peu propice à la circulation de l’air, de l’eau, et à la propagation des racines dans le sol. Elle a tendance à garder la fraicheur et l’humidité. Changeant d’humeur en fonction du temps, elle est dure, sèche et fileuse par temps chaud, mais devient molle et collante par temps humide.'],
            ['name' => 'Terre calcaire', 'code' => 'limestone', 'description' => 'L\'avantage de ce type de terre, c’est qu’elle est facile à travailler. Une terre calcaire draine efficacement le sol, avec peut-être même un peu trop de zèle, les éléments nutritifs risquant d’être emportés par les lessivages. Pour profiter au mieux de cette terre, il est préférable de la bêcher au printemps, et de la protéger à l’aide d’engrais verts comme couvre-sols.'],
            ['name' => 'Terre sableuse', 'code' => 'sand', 'description' => 'La terre sableuse est à la terre argileuse ce que le Ying est au Yang. En effet la terre sableuse est composée de grosse particules, ce qui en fait une terre légère et ne retenant que très peu l’eau. L’eau étant l’endroit où se trouvent les éléments nutritifs dissous, une terre trop sableuse n’est donc pas souhaitable.'],
            ['name' => 'Terre siliceuse', 'code' => 'silica', 'description' => 'La terre siliceuse est très pauvre en calcaire, et peut se dessécher aussi vite qu’elle se refroidit. C’est une terre qui nécessite un apport en calcaire, par l’intermédiaire de chaux par exemple, sans quoi elle restera très peu favorable à la culture.'],
            ['name' => 'Terre tourbeuse', 'code' => 'peaty', 'description' => 'Une terre tourbeuse a pour caractéristiques d’être acide, riche en matière organiques et pourtant pauvre en nutriments. Un sol tourbeux constitue une véritable éponge géante en hiver, la tourbe absorbant l’eau à cette saison pour la restituer en été. Cette terre pouvant être travaillée par tous les temps, a besoin pour devenir cultivable d’un apport en chaux.'],
            ['name' => 'Terre humifère', 'code' => 'humus', 'description' => 'Il s’agit d’une terre plutôt grumeleuse, proche de la terre argileuse mais néanmoins plus nutritive que cette dernière. Se tassant très vite par temps humide, il est préférable d’éviter au maximum de marcher dessus pour ne pas trop la tasser.'],
        ];

        foreach ($soilTypes as $st){
            $soilType = new SoilType($st['name'], $st['code'], $st['description']);
            $this->manager->persist($soilType);
        }

        $this->manager->flush();

        return true;
    }

    protected function loadLifeCycleSteps(): bool
    {
        $lifeCycleSteps = [
            ['name' => 'Germination', 'code' => 'germing', 'description' => 'Une pousse sort de la graine ! Des racines commences à se former.'],
            ['name' => 'Croissance', 'code' => 'growth', 'description' => 'La jeune plante grandit ! Elle atteindra bientôt une taille suffisante pour la suite de son cycle de vie.'],
            ['name' => 'Floraison', 'code' => 'flowering', 'description' => 'Des fleurs ont éclos ! La floraison est la période durant laquelle les fleurs de la plante se déploient.'],
            ['name' => 'Pollinisation', 'code' => 'pollinate', 'description' => 'Il est temps de polliniser ! Cela permettra à votre plante de former de beaux fruits.'],
            ['name' => 'Fructification', 'code' => 'fruct', 'description' => 'Les fruits commencent à se former. Attendez qu\'ils soient mûrs avant de les ramasser !'],
            ['name' => 'Récolte', 'code' => 'harvest', 'description' => 'Il est temps. Attendez la maturation parfaite, et ramassez le fruit de votre travail.'],
        ];

        foreach ($lifeCycleSteps as $ls){
            $lifeCycleStep = new LifeCycleStep($ls['name'], $ls['code'], $ls['description']);
            $this->manager->persist($lifeCycleStep);
        }

        $this->manager->flush();

        return true;
    }

    protected function loadFertilizerTypes(): bool
    {
        $fertilizerTypes = [
            ['name' => 'Riche en azote', 'code' => 'N', 'description' => 'Les plantes dont les besoins en azote (N) sont les plus importants sont les plantes qui développent essentiellement des feuilles comme, par exemple: les légumes feuilles (épinard, salades, oseille…), le gazon, les graminées, les plantes vertes d\'intérieur, les bambous et autres arbustes à feuillage décoratif.'],
            ['name' => 'Riche en potassium', 'code' => 'K', 'description' => 'Les végétaux demandant de la potasse (K) sont les arbustes à fleurs, les arbres fruitiers, les bulbes, les légumes racines et les rosiers.'],
            ['name' => 'Riche en phosphore', 'code' => 'P', 'description' => 'Celles qui demandent plus de phosphore (P) sont principalement des végétaux à fleurs, et donc à fruits mais aussi les légumes graines comme les pois, les lentilles...'],
            ['name' => 'Riche en azote et en potassium', 'code' => 'N-K', 'description' => 'Cet engrais riche en minéraux est adapté aux plantes ayant d\'importants besoins en azote et en phosphore.'],
            ['name' => 'Riche en azote et en phosphore', 'code' => 'N-P', 'description' => 'Cet engrais riche en minéraux est adapté aux plantes ayant d\'importants besoins en azote et en potassium.'],
            ['name' => 'Riche en potassium et en phosphore', 'code' => 'K-P', 'description' => 'Cet engrais riche en minéraux est adapté aux plantes ayant d\'importants besoins en potassium et en phosphore.'],
        ];

        foreach ($fertilizerTypes as $ft){
            $fertilizerType = new FertilizerType($ft['name'], $ft['code'], $ft['description']);
            $this->manager->persist($fertilizerType);
        }

        $this->manager->flush();

        return true;
    }

    //TODO facto
    protected function loadPlants(): bool
    {
        $tomato = new Plant(
            'Plant de tomate',
            'Solanum lycopersicum',
            '',
            $this->getPlantFamilyByCode( 'fructable'),
            12
        );
        $tomato->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 5, 6));
        $tomato->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 4, 5));
        $tomato->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 3, 4));
        $tomato->addPreferedSoilType(new PlantSoilType($tomato, $this->getSoilTypeByCode( 'humus'), 100));
        $tomato->addPreferedSoilType(new PlantSoilType($tomato, $this->getSoilTypeByCode( 'clay'), 67));
        $tomato->addPreferedSunExposureType(new PlantSunExposureType($tomato, $this->getSunExposureTypeByCode( 'sun'), 100));
        $tomato->addPreferedFertilizerType(new PlantFertilizerType($tomato, $this->getFertilizerTypeByCode( 'N-K'), 100, 9));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStepByCode( 'germing'), 9, 1));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStepByCode( 'growth'), 120, 2));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStepByCode( 'flowering'), 7, 3));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStepByCode( 'fruct'), 45, 4));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStepByCode( 'harvest'), 7, 5));
        $this->tomato = $tomato;

        $appleTree = new Plant(
            'Pommier',
            'Malus',
            '',
            $this->getPlantFamilyByCode( 'fructable'),
            12
        );
        $appleTree->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 11, 2));
        $appleTree->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 11, 2));
        $appleTree->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 11, 2));
        $appleTree->addPreferedSoilType(new PlantSoilType($appleTree, $this->getSoilTypeByCode( 'limestone'), 100));
        $appleTree->addPreferedSoilType(new PlantSoilType($appleTree, $this->getSoilTypeByCode( 'silica'), 75));
        $appleTree->addPreferedSoilType(new PlantSoilType($appleTree, $this->getSoilTypeByCode( 'clay'), 32));
        $appleTree->addPreferedSunExposureType(new PlantSunExposureType($appleTree, $this->getSunExposureTypeByCode( 'sun'), 100));
        $appleTree->addPreferedFertilizerType(new PlantFertilizerType($appleTree, $this->getFertilizerTypeByCode( 'N-K'), 97, 15));
        $appleTree->addPreferedFertilizerType(new PlantFertilizerType($appleTree, $this->getFertilizerTypeByCode( 'N'), 64, 9));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStepByCode( 'germing'), 9, 1));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStepByCode( 'growth'), 1095, 2));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStepByCode( 'pollinate'), 15, 3));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStepByCode( 'flowering'), 7, 4));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStepByCode( 'fruct'), 90, 5));

        $carrot = new Plant(
            'Carotte',
            'Daucus carota',
            '',
            $this->getPlantFamilyByCode( 'eatable'),
            12
        );
        $carrot->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 3, 4));
        $carrot->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 3, 4));
        $carrot->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 2, 3));
        $carrot->addPreferedSoilType(new PlantSoilType($carrot, $this->getSoilTypeByCode( 'humus'), 95));
        $carrot->addPreferedSoilType(new PlantSoilType($carrot, $this->getSoilTypeByCode( 'clay'), 49));
        $carrot->addPreferedSunExposureType(new PlantSunExposureType($carrot, $this->getSunExposureTypeByCode( 'sun'), 94));
        $carrot->addPreferedFertilizerType(new PlantFertilizerType($carrot, $this->getFertilizerTypeByCode( 'K-P'), 100, 15));
        $carrot->addLifeCycleStep(new PlantLifeCycleStep($carrot, $this->getLifeCycleStepByCode( 'germing'), 30, 1));
        $carrot->addLifeCycleStep(new PlantLifeCycleStep($carrot, $this->getLifeCycleStepByCode( 'growth'), 150, 2));
        $carrot->addLifeCycleStep(new PlantLifeCycleStep($carrot, $this->getLifeCycleStepByCode( 'harvest'), 7, 3));

        $radish = new Plant(
            'Radis',
            'Raphanus sativus',
            '',
            $this->getPlantFamilyByCode( 'eatable'),
            12
        );
        $radish->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 3, 5));
        $radish->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 3, 5));
        $radish->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 2, 4));
        $radish->addPreferedSoilType(new PlantSoilType($radish, $this->getSoilTypeByCode( 'humus'), 100));
        $radish->addPreferedSoilType(new PlantSoilType($radish, $this->getSoilTypeByCode( 'sand'), 66));
        $radish->addPreferedSoilType(new PlantSoilType($radish, $this->getSoilTypeByCode( 'clay'), 37));
        $radish->addPreferedSunExposureType(new PlantSunExposureType($radish, $this->getSunExposureTypeByCode( 'sun'), 97));
        $radish->addPreferedSunExposureType(new PlantSunExposureType($radish, $this->getSunExposureTypeByCode( 'half-sun'), 71));
        $radish->addPreferedFertilizerType(new PlantFertilizerType($radish, $this->getFertilizerTypeByCode( 'K-P'), 87, 15));
        $radish->addLifeCycleStep(new PlantLifeCycleStep($radish, $this->getLifeCycleStepByCode( 'germing'), 8, 1));
        $radish->addLifeCycleStep(new PlantLifeCycleStep($radish, $this->getLifeCycleStepByCode( 'growth'), 120, 2));
        $radish->addLifeCycleStep(new PlantLifeCycleStep($radish, $this->getLifeCycleStepByCode( 'harvest'), 7, 3));

        $geranium = new Plant(
            'Géranium',
            'Geranium',
            '',
            $this->getPlantFamilyByCode( 'flower'),
            12
        );
        $geranium->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 4, 5));
        $geranium->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 4, 5));
        $geranium->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 3, 4));
        $geranium->addPreferedSoilType(new PlantSoilType($geranium, $this->getSoilTypeByCode( 'clay'), 99));
        $geranium->addPreferedSunExposureType(new PlantSunExposureType($geranium, $this->getSunExposureTypeByCode( 'sun'), 99));
        $geranium->addPreferedSunExposureType(new PlantSunExposureType($geranium, $this->getSunExposureTypeByCode( 'half-sun'), 59));
        $geranium->addPreferedSunExposureType(new PlantSunExposureType($geranium, $this->getSunExposureTypeByCode( 'shadow'), 55));
        $geranium->addPreferedFertilizerType(new PlantFertilizerType($geranium, $this->getFertilizerTypeByCode( 'K'), 80, 15));
        $geranium->addLifeCycleStep(new PlantLifeCycleStep($geranium, $this->getLifeCycleStepByCode( 'germing'), 8, 1));
        $geranium->addLifeCycleStep(new PlantLifeCycleStep($geranium, $this->getLifeCycleStepByCode( 'growth'), 90, 2));
        $geranium->addLifeCycleStep(new PlantLifeCycleStep($geranium, $this->getLifeCycleStepByCode( 'flowering'), 180, 3));

        $daffodil = new Plant(
            'Jonquille véritable',
            'Narcissus jonquilla',
            '',
            $this->getPlantFamilyByCode( 'flower'),
            12
        );
        $daffodil->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 10, 11));
        $daffodil->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 9, 10));
        $daffodil->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 9, 10));
        $daffodil->addPreferedSoilType(new PlantSoilType($daffodil, $this->getSoilTypeByCode( 'humus'), 93));
        $daffodil->addPreferedSoilType(new PlantSoilType($daffodil, $this->getSoilTypeByCode( 'clay'), 68));
        $daffodil->addPreferedSunExposureType(new PlantSunExposureType($daffodil, $this->getSunExposureTypeByCode( 'sun'), 88));
        $daffodil->addPreferedFertilizerType(new PlantFertilizerType($daffodil, $this->getFertilizerTypeByCode( 'N'), 92,15));
        $daffodil->addLifeCycleStep(new PlantLifeCycleStep($daffodil, $this->getLifeCycleStepByCode( 'germing'), 90, 1));
        $daffodil->addLifeCycleStep(new PlantLifeCycleStep($daffodil, $this->getLifeCycleStepByCode( 'growth'), 90, 2));
        $daffodil->addLifeCycleStep(new PlantLifeCycleStep($daffodil, $this->getLifeCycleStepByCode( 'flowering'), 21, 3));

        $fir = new Plant(
            'Sapin',
            'Abies',
            '',
            $this->getPlantFamilyByCode( 'other'),
            1
        );
        $fir->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 5, 11));
        $fir->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 4, 10));
        $fir->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 4, 10));
        $fir->addPreferedSoilType(new PlantSoilType($fir, $this->getSoilTypeByCode( 'clay'), 95));
        $fir->addPreferedSoilType(new PlantSoilType($fir, $this->getSoilTypeByCode( 'humus'), 88));
        $fir->addPreferedSoilType(new PlantSoilType($fir, $this->getSoilTypeByCode( 'sand'), 68));
        $fir->addPreferedSoilType(new PlantSoilType($fir, $this->getSoilTypeByCode( 'limestone'), 55));
        $fir->addPreferedSunExposureType(new PlantSunExposureType($fir, $this->getSunExposureTypeByCode( 'sun'), 100));
        $fir->addPreferedFertilizerType(new PlantFertilizerType($fir, $this->getFertilizerTypeByCode( 'K'), 98,15));
        $fir->addPreferedFertilizerType(new PlantFertilizerType($fir, $this->getFertilizerTypeByCode( 'N-K'), 65,15));
        $fir->addPreferedFertilizerType(new PlantFertilizerType($fir, $this->getFertilizerTypeByCode( 'K-P'), 38,15));
        $fir->addLifeCycleStep(new PlantLifeCycleStep($fir, $this->getLifeCycleStepByCode( 'germing'), 180, 1));
        $fir->addLifeCycleStep(new PlantLifeCycleStep($fir, $this->getLifeCycleStepByCode( 'growth'), 730, 2));
        $fir->addLifeCycleStep(new PlantLifeCycleStep($fir, $this->getLifeCycleStepByCode( 'pollinate'), 30, 3));
        $fir->addLifeCycleStep(new PlantLifeCycleStep($fir, $this->getLifeCycleStepByCode( 'flowering'), 90, 4));
        $fir->addLifeCycleStep(new PlantLifeCycleStep($fir, $this->getLifeCycleStepByCode( 'fruct'), 180, 5));

        $fern = new Plant(
            'Fougère',
            'Filicophyta',
            '',
            $this->getPlantFamilyByCode( 'other'),
            12
        );
        $fern->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 5, 11));
        $fern->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 4, 10));
        $fern->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 4, 10));
        $fern->addPreferedSoilType(new PlantSoilType($fern, $this->getSoilTypeByCode( 'peaty'), 98));
        $fern->addPreferedSunExposureType(new PlantSunExposureType($fern, $this->getSunExposureTypeByCode( 'shadow'), 96));
        $fern->addPreferedSunExposureType(new PlantSunExposureType($fern, $this->getSunExposureTypeByCode( 'half-sun'), 66));
        $fern->addPreferedFertilizerType(new PlantFertilizerType($fern, $this->getFertilizerTypeByCode( 'N'), 77,15));
        $fern->addLifeCycleStep(new PlantLifeCycleStep($fern, $this->getLifeCycleStepByCode( 'germing'), 180, 1));
        $fern->addLifeCycleStep(new PlantLifeCycleStep($fern, $this->getLifeCycleStepByCode( 'growth'), 3650, 2));

        foreach ([$tomato, $appleTree, $carrot, $radish, $geranium, $daffodil, $fir, $fern] as $obj) {
            $this->manager->persist($obj);
        }

        $this->manager->flush();

        return true;
    }

    protected function loadGardens(): bool
    {
        $gardens = [
            ['user' => $this->userTest, 'name' => 'Jardin Test 1', 'latitude' => 46.215083, 'longitude' => 5.241825, 'height' => 5, 'length' => 5],
        ];

        foreach ($gardens as $g){
            $garden = new Garden($g['user'], $g['name'], $g['latitude'], $g['longitude'], $g['height'], $g['length']);
            $garden->setCountry($this->manager->getRepository("App\Entity\Util\Country")->findOneBy(['code' => 'fra']));
            $this->manager->persist($garden);

            for ($i = 0 ; $i <= $g['height'] ; $i++) {
                for ($j = 0 ; $j <= $g['height'] ; $j++){
                    $plot = new Plot(
                        strval($i + $j + 1),
                        $this->getSunExposureTypeByCode('sun'),
                        $this->getSoilTypeByCode('humus')
                    );

                    if($i == 0 && $j == 0){
                        $specimen = new Specimen(
                            $this->tomato,
                            new \DateTimeImmutable('now', new \DateTimeZone('UTC')),
                        );
                        $plot->addSpecimen($specimen);
                    }
                    $garden->addPlot($plot);
                }

            }

            $this->manager->persist($garden);
        }

        $this->manager->flush();

        return true;
    }
}