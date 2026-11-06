<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Song;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SongFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $songs[] = new Song()
            ->setTitle('Calm and ocean');

        $songs[] = new Song()
            ->setTitle('Calm and wind');

        $songs[] = new Song()
            ->setTitle('Calm and mountain');

        foreach ($songs as $song) {
            $manager->persist($song);
        }


        $album = new Album()
            ->setTitle('Calm and landscapes')
            ->addSong($songs[0])
            ->addSong($songs[1])
            ->addSong($songs[2]);

        $manager->persist($album);

        $manager->flush();
    }
}
