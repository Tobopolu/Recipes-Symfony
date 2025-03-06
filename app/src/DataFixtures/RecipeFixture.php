<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RecipeFixture extends Fixture {

    private $faker;

    public function __construct() {

        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager):void {

        for ($i = 0; $i < 50; $i++) {
            $manager->persist($this->getRecipe());
        }
        $manager->flush();
    }

    private function getRecipe() {

        return new Recipe(
            $this->faker->paragraph(),
            $this->faker->sentence(10),
            $this->faker->sentence(27)
        );
    }
}



