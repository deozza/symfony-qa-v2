<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, type: 'string', unique: true, nullable: false)]
    private string $email;

    private string $username;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;


    public function getId(): int {
        return $this->id;
    }
}
