<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AppFixtures
 *
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * Main method to load fixtures.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $manager->flush();
    }
}
