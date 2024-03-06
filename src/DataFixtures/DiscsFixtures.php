<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Disc;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiscsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        include 'record.php';
        $artistRepo = $manager->getRepository(Artist::class);

        foreach ($artist as $art){
            //$this->logger->debug('Contenu de l\'objet:', ['object' => var_export($art, true)]);
            $artistDB = new Artist();
            $artistDB
            ->setId($art['artist_id'])
            ->setArtistName($art['artist_name'])
            ->setArtistUrl($art['artist_url']);

            $manager->persist($artistDB);
            $metadata = $manager->getClassMetadata(Artist::class);
            $metadata->setIdgeneratorType(\DOctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $manager->flush();

        foreach ($disc as $d) {
            $discDB = new Disc();
            $discDB
            ->setTitle($d['disc_title'])
            ->setLabel($d['disc_label'])
            ->setPicture($d['disc_picture']);
            $artist = $artistRepo->find($d['artist_id']);
            $discDB->setArtist($artist);
            $manager->persist($discDB);
        }
        $manager->flush();
    }
}
