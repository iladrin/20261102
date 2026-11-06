<?php

namespace App\Song;

use Symfony\Component\Validator\Constraints as Assert;
class SongData
{
    #[Assert\NotBlank]
    public string $title;

    public int $duration;
}
