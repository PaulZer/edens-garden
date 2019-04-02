<?php


namespace App\DataFixtures;


use App\Entity\Plant\ClimaticArea;
use App\Entity\Plant\FertilizerType;
use App\Entity\Plant\LifeCycleStep;
use App\Entity\Plant\PlantFamily;
use App\Entity\Plant\SoilType;
use App\Entity\Plant\SunExposureType;
use App\Entity\User;
use App\Entity\Util\Month;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $manager = null;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->loadMonths();

        $this->loadClimaticAreas();

        $this->loadUsersFixtures();

        $this->loadPlantFamilies();

        $this->loadSunExposureTypes();

        $this->loadSoilTypes();

        $this->loadLifeCycleSteps();

        $this->loadFertilizerTypes();
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

    protected function loadUsersFixtures(): bool
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
}