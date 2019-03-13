<?php

namespace App\DataFixtures;


use App\Entity\Plant\ClimaticArea;
use App\Entity\Plant\LifeCycleStep;
use App\Entity\Plant\PlantFamily;
use App\Entity\Plant\PlantingDateInterval;
use App\Entity\Plant\SoilType;
use App\Entity\Plant\SunExposureType;
use App\Entity\Util\Country;
use App\Entity\Util\Month;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppDataFixtures extends Fixture
{
    public  function load(ObjectManager $manager)
    {
        $ca1 = new ClimaticArea('Nord de la France', 'fra-n',51.165673, 47.997468);
        $ca2 = new ClimaticArea('Centre de la France', 'fra-m',47.997468, 45.772231);
        $ca3 = new ClimaticArea('Sud de la France', 'fra-s', 45.772231, 42.342657);

        foreach ([$ca1, $ca2, $ca3] as $obj) {
            $manager->persist($obj);
        }

        $c1 = new Country('France', 'fra', $ca1, $ca2, $ca3);

        $manager->persist($c1);

        $m1 = new Month('Janvier', 1);
        $m2 = new Month('Février', 2);
        $m3 = new Month('Mars', 3);
        $m4 = new Month('Avril', 4);
        $m5 = new Month('Mai', 5);
        $m6 = new Month('Juin', 6);
        $m7 = new Month('Juillet', 7);
        $m8 = new Month('Août', 8);
        $m9 = new Month('Septembre', 9);
        $m10 = new Month('Octobre', 10);
        $m11 = new Month('Novembre', 11);
        $m12 = new Month('Décembre', 12);


        $months = [$m1, $m2, $m3, $m4, $m5, $m6, $m7, $m8, $m9, $m10, $m11, $m12];
        foreach ($months as $obj){
            $manager->persist($obj);
        }
        foreach ([$ca1, $ca2, $ca3] as $ca){
            foreach ($months as $mBegin){
                foreach ($months as $mEnd){
                    if($mBegin !== $mEnd){
                        $pdi = new PlantingDateInterval($mBegin, $mEnd, $ca);
                        $manager->persist($pdi);
                    }
                }
            }
        }

        $pf1 = new PlantFamily('Plantes à fruits', 'fructable', 'Plantes nécessitant une fructification optimale avant récolte des fruits.');
        $pf2 = new PlantFamily('Plantes  comestibles','eatable', 'Plantes entièrement ou partiellement comestibles, atteignant une maturation avant d\'être entièrement récoltées.');
        $pf3 = new PlantFamily('Fleurs', 'flower','Les fleurs sont cultivées à but décoratif, elle doivent avoir une durée de vie après floraison longue.');
        $pf4 = new PlantFamily('Autre', 'other','Plantes n\'atteignant pas de floraison ou de fructification.');

        foreach ([$pf1, $pf2, $pf3, $pf4] as $obj){
            $manager->persist($obj);
        }

        $sut1 = new SunExposureType('Ensoleillée', 'sun','Il est préférable de faire pousser certaines plantes dans des milieux très ensoileillés, au moins 6 ou 8 heures par jour selon les espèces.');
        $sut2 = new SunExposureType('Semi-ensoleillée', 'half-sun','Un milieu semi-ensoleillé, ou semi-ombragé, convient très bien à une grande variété de plantes.');
        $sut3 = new SunExposureType('Ombragée', 'shadow','Une exposition ombragée est préférée de certaines expèces de plantes, qui en partie ne survivent pas bien trop longtemps exposées à la chaleur du soleil.');

        foreach ([$sut1, $sut2, $sut3] as $obj){
            $manager->persist($obj);
        }

        $st1 = new SoilType('Terre argileuse', 'clay','La terre argileuse, formée de petites particules, est très compacte. Cette densité la rend peu propice à la circulation de l’air, de l’eau, et à la propagation des racines dans le sol. Elle a tendance à garder la fraicheur et l’humidité. Changeant d’humeur en fonction du temps, elle est dure, sèche et fileuse par temps chaud, mais devient molle et collante par temps humide.');
        $st2 = new SoilType('Terre calcaire', 'limestone','L\'avantage de ce type de terre, c’est qu’elle est facile à travailler. Une terre calcaire draine efficacement le sol, avec peut-être même un peu trop de zèle, les éléments nutritifs risquant d’être emportés par les lessivages. Pour profiter au mieux de cette terre, il est préférable de la bêcher au printemps, et de la protéger à l’aide d’engrais verts comme couvre-sols.');
        $st3 = new SoilType('Terre sableuse', 'sand','La terre sableuse est à la terre argileuse ce que le Ying est au Yang. En effet la terre sableuse est composée de grosse particules, ce qui en fait une terre légère et ne retenant que très peu l’eau. L’eau étant l’endroit où se trouvent les éléments nutritifs dissous, une terre trop sableuse n’est donc pas souhaitable.');
        $st4 = new SoilType('Terre siliceuse', 'silica','La terre siliceuse est très pauvre en calcaire, et peut se dessécher aussi vite qu’elle se refroidit. C’est une terre qui nécessite un apport en calcaire, par l’intermédiaire de chaux par exemple, sans quoi elle restera très peu favorable à la culture.');
        $st5 = new SoilType('Terre tourbeuse', 'peaty','Une terre tourbeuse a pour caractéristiques d’être acide, riche en matière organiques et pourtant pauvre en nutriments. Un sol tourbeux constitue une véritable éponge géante en hiver, la tourbe absorbant l’eau à cette saison pour la restituer en été. Cette terre pouvant être travaillée par tous les temps, a besoin pour devenir cultivable d’un apport en chaux.');
        $st6 = new SoilType('Terre humifère', 'humus','Il s’agit d’une terre plutôt grumeleuse, proche de la terre argileuse mais néanmoins plus nutritive que cette dernière. Se tassant très vite par temps humide, il est préférable d’éviter au maximum de marcher dessus pour ne pas trop la tasser.');

        foreach ([$st1, $st2, $st3, $st4, $st5, $st6] as $obj){
            $manager->persist($obj);
        }

        $lcs1 = new LifeCycleStep('Germination', 'germing', 'Une pousse sort de la graine ! Des racines commences à se former.');
        $lcs2 = new LifeCycleStep('Croissance', 'growth', 'La jeune plante grandit ! Elle atteindra bientôt une taille suffisante pour la suite de son cycle de vie.');
        $lcs3 = new LifeCycleStep('Floraison', 'flowering', 'Des fleurs ont éclos ! La floraison est la période durant laquelle les fleurs de la plante se déployent.');
        $lcs4 = new LifeCycleStep('Pollinisation', 'pollinate', 'Il est temps de polliniser ! Cela permettra à votre plante de former de beaux fruits.');
        $lcs5 = new LifeCycleStep('Fructification', 'fruct', 'Les fruits commencent à se former. Attendez qu\'ils soient mûrs avant de les ramasser !');
        $lcs6 = new LifeCycleStep('Récolte','harvest', 'Il est temps. Attendez la maturation parfaite, et ramassez le fruit de votre travail.');

        foreach ([$lcs1, $lcs2, $lcs3, $lcs4, $lcs5, $lcs6] as $obj){
            $manager->persist($obj);
        }

        $manager->flush();
    }
}