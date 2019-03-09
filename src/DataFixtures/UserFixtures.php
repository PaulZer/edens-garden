<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $paul = new User();
        $paul->setFirstName('Paul');
        $paul->setLastName('Bouchillou');
        $paul->setRoles(['ROLE_ADMIN']);
        $paul->setEmail('bouchilloupaul@gmail.com');
        $paul->setPassword('$argon2i$v=19$m=1024,t=2,p=2$RVZ4NkoyNC53bkVES09yZg$q3LccGIDmDD9lug0b+rmhKhPEcMlkQl1Wo0uL5Te8ss');

        $manager->persist($paul);

        $manager->flush();
    }
}