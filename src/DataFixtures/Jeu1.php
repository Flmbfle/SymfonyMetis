<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Disc;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Jeu1 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        $artist1 = new Artist();

        $artist1->setArtistName("Queens Of The Stone Age");
        $artist1->setArtistUrl("https://google.fr");

        $manager->persist($artist1);

        $disc1 = new Disc();
        $disc1->setTitle("Songs for the Deaf");
        $disc1->setPicture("https://en.wikipedia.org/wiki/Songs_for_the_Deaf#/media/File:Queens_of_the_Stone_Age_-_Songs_for_thue_Deaf.png");
        $disc1->setLabel("Interscope Records");

        $manager->persist($disc1);

        //Pour associer les entités
        $artist1->addDisc($disc1);

        $manager->flush();
    }
}
