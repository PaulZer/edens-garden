<?php

namespace App\DataFixtures;

use App\Entity\Plant\ClimaticArea;
use App\Entity\Plant\PlantingDateInterval;
use App\Entity\Util\Country;
use App\Entity\Util\Month;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PlantDataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /*$ca1 = new ClimaticArea('Nord de la France', 'fra-n',51.165673, 47.997468);
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

        $manager->flush();*/
    }
}