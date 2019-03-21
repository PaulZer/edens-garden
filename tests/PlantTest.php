<?php

namespace App\Tests;


use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantFamily;
use PHPUnit\Framework\TestCase;

class PlantTest extends TestCase
{
    public function testPlantCanBeCreated(): void
    {
        $tomato = new Plant(
            'Plant de tomate',
            'Solanum lycopersicum',
            '',
            new PlantFamily('test', 'test', 'lorem'),
            12
        );

        $this->assertInstanceOf(
            Plant::class,
            $tomato
        );
    }
}