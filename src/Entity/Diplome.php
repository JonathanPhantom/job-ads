<?php

namespace App\Entity;

use App\Repository\DiplomeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiplomeRepository::class)
 */
class Diplome
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $dateObtention;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateObtention(): ?int
    {
        return $this->dateObtention;
    }

    public function setDateObtention(int $dateObtention): self
    {
        $this->dateObtention = $dateObtention;

        return $this;
    }
}
