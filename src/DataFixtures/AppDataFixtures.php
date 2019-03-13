<?php

namespace App\DataFixtures;


use App\Entity\Plant\LifeCycleStep;
use App\Entity\Plant\PlantFamily;
use App\Entity\Plant\SoilType;
use App\Entity\Plant\SunExposureType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppDataFixtures extends Fixture
{
    public  function load(ObjectManager $manager)
    {
        $pf1 = new PlantFamily('Plantes à fruits', 'fructable', 'Plantes nécessitant une fructification optimale avant récolte des fruits.');
        $pf2 = new PlantFamily('Plantes  comestibles','eatable', 'Plantes entièrement ou partiellement comestibles, atteignant une maturation avant d\'être entièrement récoltées.');
        $pf3 = new PlantFamily('Fleurs', 'flower','Les fleurs sont cultivées à but décoratif, elle doivent avoir une durée de vie après floraison longue.');
        $pf4 = new PlantFamily('Autre', 'other','Plantes n\'atteignant pas de floraison ou de fructification.');

        $manager->persist($pf1);
        $manager->persist($pf2);
        $manager->persist($pf3);
        $manager->persist($pf4);

        $sut1 = new SunExposureType('Ensoleillée', 'sun','Il est préférable de faire pousser certaines plantes dans des milieux très ensoileillés, au moins 6 ou 8 heures par jour selon les espèces.');
        $sut2 = new SunExposureType('Semi-ensoleillée', 'half-sun','Un milieu semi-ensoleillé, ou semi-ombragé, convient très bien à une grande variété de plantes.');
        $sut3 = new SunExposureType('Ombragée', 'shadow','Une exposition ombragée est préférée de certaines expèces de plantes, qui en partie ne survivent pas bien trop longtemps exposées à la chaleur du soleil.');

        $manager->persist($sut1);
        $manager->persist($sut2);
        $manager->persist($sut3);

        $st1 = new SoilType('Terre argileuse', 'clay','La terre argileuse, formée de petites particules, est très compacte. Cette densité la rend peu propice à la circulation de l’air, de l’eau, et à la propagation des racines dans le sol. Elle a tendance à garder la fraicheur et l’humidité. Changeant d’humeur en fonction du temps, elle est dure, sèche et fileuse par temps chaud, mais devient molle et collante par temps humide.');
        $st2 = new SoilType('Terre calcaire', 'limestone','L\'avantage de ce type de terre, c’est qu’elle est facile à travailler. Une terre calcaire draine efficacement le sol, avec peut-être même un peu trop de zèle, les éléments nutritifs risquant d’être emportés par les lessivages. Pour profiter au mieux de cette terre, il est préférable de la bêcher au printemps, et de la protéger à l’aide d’engrais verts comme couvre-sols.');
        $st3 = new SoilType('Terre sableuse', 'sand','La terre sableuse est à la terre argileuse ce que le Ying est au Yang. En effet la terre sableuse est composée de grosse particules, ce qui en fait une terre légère et ne retenant que très peu l’eau. L’eau étant l’endroit où se trouvent les éléments nutritifs dissous, une terre trop sableuse n’est donc pas souhaitable.');
        $st4 = new SoilType('Terre siliceuse', 'silica','La terre siliceuse est très pauvre en calcaire, et peut se dessécher aussi vite qu’elle se refroidit. C’est une terre qui nécessite un apport en calcaire, par l’intermédiaire de chaux par exemple, sans quoi elle restera très peu favorable à la culture.');
        $st5 = new SoilType('Terre tourbeuse', 'peaty','Une terre tourbeuse a pour caractéristiques d’être acide, riche en matière organiques et pourtant pauvre en nutriments. Un sol tourbeux constitue une véritable éponge géante en hiver, la tourbe absorbant l’eau à cette saison pour la restituer en été. Cette terre pouvant être travaillée par tous les temps, a besoin pour devenir cultivable d’un apport en chaux.');
        $st6 = new SoilType('Terre humifère', 'humus','Il s’agit d’une terre plutôt grumeleuse, proche de la terre argileuse mais néanmoins plus nutritive que cette dernière. Se tassant très vite par temps humide, il est préférable d’éviter au maximum de marcher dessus pour ne pas trop la tasser.');

        $manager->persist($st1);
        $manager->persist($st2);
        $manager->persist($st3);
        $manager->persist($st4);
        $manager->persist($st5);
        $manager->persist($st6);

        $lcs1 = new LifeCycleStep('Germination', 1, 'germing', 'Une pousse sort de la graine ! Des racines commences à se former.');
        $lcs2 = new LifeCycleStep('Croissance', 2, 'growth', 'La jeune plante grandit ! Elle atteindra bientôt une taille suffisante pour la suite de son cycle de vie.');
        $lcs3 = new LifeCycleStep('Floraison', 3, 'flowering', 'Des fleurs ont éclos ! La floraison est la période durant laquelle les fleurs de la plante se déployent.');
        $lcs4 = new LifeCycleStep('Pollinisation', 4, 'pollinate', 'Il est temps de polliniser ! Cela permettra à votre plante de former de beaux fruits.');
        $lcs6 = new LifeCycleStep('Fructification', 5, 'fruct', 'Les fruits commencent à se former. Attendez qu\'ils soient mûrs avant de les ramasser !');
        $lcs5 = new LifeCycleStep('Récolte', 6, 'harvest', 'Il est temps. Attendez la maturation parfaite, et ramassez le fruit de votre travail.');

        $manager->persist($lcs1);
        $manager->persist($lcs2);
        $manager->persist($lcs3);
        $manager->persist($lcs4);
        $manager->persist($lcs5);
        $manager->persist($lcs6);

        $manager->flush();
    }
}