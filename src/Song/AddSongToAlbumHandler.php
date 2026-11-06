<?php

namespace App\Song;

use App\Entity\Album;
use App\Entity\Song;
use Doctrine\ORM\EntityManagerInterface;

readonly class AddSongToAlbumHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function __invoke(SongData $data, Album $album): void
    {
        $song = new Song()
            ->setTitle($data->title)
            ->setDuration($data->duration);

        $this->entityManager->persist($song);

        $album->addSong($song);

        $this->entityManager->flush();
    }
}
