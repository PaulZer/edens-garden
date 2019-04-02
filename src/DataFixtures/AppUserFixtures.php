<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppUserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /*$paul = new User();
        $paul->setFirstName('Paul');
        $paul->setLastName('Bouchillou');
        $paul->setRoles(['ROLE_ADMIN']);
        $paul->setEmail('bouchilloupaul@gmail.com');
        $paul->setPassword('$argon2i$v=19$m=1024,t=2,p=2$RVZ4NkoyNC53bkVES09yZg$q3LccGIDmDD9lug0b+rmhKhPEcMlkQl1Wo0uL5Te8ss');

        $mateo = new User();
        $mateo->setFirstName('Matéo');
        $mateo->setLastName('Rat');
        $mateo->setRoles(['ROLE_ADMIN']);
        $mateo->setEmail('mateo.rat01@gmail.com');
        $mateo->setPassword('$argon2i$v=19$m=1024,t=2,p=2$Rm1nVmVlYzdSSVdIbGluMQ$TZrfT3uvay2KKTpTzjFhFT43uvBcYYIBNLzsVeAuXwM');

        $yoann = new User();
        $yoann->setFirstName('Yoann');
        $yoann->setLastName('Dufour');
        $yoann->setRoles(['ROLE_ADMIN']);
        $yoann->setEmail('yoann01.d@gmail.com');
        $yoann->setPassword('$argon2i$v=19$m=1024,t=2,p=2$dVcyclpHamRHdHM1SnJpYg$R0Zo7zCBvn9EJT3njmuWNhpWG9NZd1i3FAeMJlrlCls');

        $elio = new User();
        $elio->setFirstName('Elliot');
        $elio->setLastName('Edwards');
        $elio->setRoles(['ROLE_ADMIN']);
        $elio->setEmail('elliot.edwards38@gmail.com');
        $elio->setPassword('$argon2i$v=19$m=1024,t=2,p=2$SW1xNlhDSmtYZ2c1TDd6Qw$SYaqgchmD+uiZhjA4i1xqeYh4cxjaH6tv7Ua4LG5xhI');

        // mdp user
        $user = new User();
        $user->setFirstName('User');
        $user->setLastName('2Test');
        $user->setRoles(['ROLE_USER']);
        $user->setEmail('eden.garden.ptut@gmail.com');
        $user->setPassword('$argon2i$v=19$m=1024,t=2,p=2$Z1NVQTQ2WGw0OGhRWVo2Mg$ktPLwnKNcJBFy9tlBuc33Ze9W+movxiaQZTPdCkLKPA');

        $manager->persist($paul);
        $manager->persist($mateo);
        $manager->persist($yoann);
        $manager->persist($elio);
        $manager->persist($user);

        $manager->flush();*/


    }
}