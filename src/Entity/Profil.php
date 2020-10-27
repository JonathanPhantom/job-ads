<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cvPath;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $competences = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $anneeExperience;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCvPath(): ?string
    {
        return $this->cvPath;
    }

    public function setCvPath(string $cvPath): self
    {
        $this->cvPath = $cvPath;

        return $this;
    }

    public function getCompetences(): ?array
    {
        return $this->competences;
    }

    public function setCompetences(?array $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    public function getAnneeExperience(): ?int
    {
        return $this->anneeExperience;
    }

    public function setAnneeExperience(int $anneeExperience): self
    {
        $this->anneeExperience = $anneeExperience;

        return $this;
    }
}
