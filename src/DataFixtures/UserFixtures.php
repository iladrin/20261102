<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Service\Attribute\Required;

class UserFixtures extends Fixture
{
    #[Required]
    public UserPasswordHasherInterface $hasher;

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setUsername('benoit')
            ->setRoles(['ROLE_USER'])
            ->setPassword(
                $this->hasher->hashPassword($user, 'demo')
            );

        $users[] = $user;

        $user = new User();
        $user
            ->setUsername('malo')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->hasher->hashPassword($user, 'demo')
            );
        $users[] = $user;

        foreach ($users as $user) {
            $manager->persist($user);
        }

        $manager->flush();
    }
}
