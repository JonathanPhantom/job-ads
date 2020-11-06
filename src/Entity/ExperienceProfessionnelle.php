<?php

namespace App\Entity;

use App\Repository\ExperienceProfessionnelleRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExperienceProfessionnelleRepository::class)
 */
class ExperienceProfessionnelle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $titrePoste;

    /**
     * @ORM\Column(type="date")
     */
    private ?DateTimeInterface $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private ?DateTimeInterface $dateFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nomEntreprise;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descriptionExperience;

    /**
     * @ORM\Column(type="localites", nullable=true)
     */
    private $localite;

    /**
     * @ORM\Column(type="domaineActivite",nullable=true)
     */
    private $secteurActivite;

    /**
     * @ORM\ManyToOne(targetEntity=Cv::class, inversedBy="experienecesProfessionnelles")
     */
    private $cv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitrePoste(): ?string
    {
        return $this->titrePoste;
    }

    public function setTitrePoste(string $titrePoste): self
    {
        $this->titrePoste = $titrePoste;

        return $this;
    }

    public function getDateDebut(): ?DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getDescriptionExperience(): ?string
    {
        return $this->descriptionExperience;
    }

    public function setDescriptionExperience(?string $descriptionExperience): self
    {
        $this->descriptionExperience = $descriptionExperience;

        return $this;
    }

    public function getLocalite()
    {
        return $this->localite;
    }

    public function setLocalite($localite): self
    {
        $this->localite = $localite;

        return $this;
    }

    public function getSecteurActivite()
    {
        return $this->secteurActivite;
    }

    public function setSecteurActivite($secteurActivite): self
    {
        $this->secteurActivite = $secteurActivite;

        return $this;
    }

    public function getCv(): ?Cv
    {
        return $this->cv;
    }

    public function setCv(?Cv $cv): self
    {
        $this->cv = $cv;

        return $this;
    }
}
