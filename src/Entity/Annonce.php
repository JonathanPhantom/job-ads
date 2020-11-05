<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 * @ORM\Table(name="annonces")
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $titreAnnonce;

    /**
     * @ORM\Column(type="date")
     */
    private $dateLimite;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $anneeExperience;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $posteAPourvoir;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $salaire;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombrePoste;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proprietaire;

    /**
     * @ORM\ManyToMany(targetEntity=Categorie::class, mappedBy="annonces")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Postulation::class, mappedBy="annonce", orphanRemoval=true)
     */
    private $candidatures;

    /**
     * @ORM\Column(type="date")
     */
    private $datePublication;

    /**
     * @ORM\Column(type="domaineEtude")
     */
    private $domaineEtude;

    /**
     * @return mixed
     */
    public function getDomaineEtude()
    {
        return $this->domaineEtude;
    }

    /**
     * @param mixed $domaineEtude
     * @return Annonce
     */
    public function setDomaineEtude($domaineEtude)
    {
        $this->domaineEtude = $domaineEtude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNiveauFormation()
    {
        return $this->niveauFormation;
    }

    /**
     * @param mixed $niveauFormation
     * @return Annonce
     */
    public function setNiveauFormation($niveauFormation)
    {
        $this->niveauFormation = $niveauFormation;
        return $this;
    }

    /**
     * @ORM\Column(type="niveauFormation")
     */
    private $niveauFormation;

    /**
     * @ORM\OneToMany(targetEntity=Signaler::class, mappedBy="annonce")
     */
    private $signales;

    /**
     * @ORM\Column(type="typeContrat")
     */
    private $typeContrat;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
        $this->signales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreAnnonce(): ?string
    {
        return $this->titreAnnonce;
    }

    public function setTitreAnnonce(string $titreAnnonce): self
    {
        $this->titreAnnonce = $titreAnnonce;

        return $this;
    }

    public function getDateLimite(): ?\DateTimeInterface
    {
        return $this->dateLimite;
    }

    public function setDateLimite(\DateTimeInterface $dateLimite): self
    {
        $this->dateLimite = $dateLimite;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPosteAPourvoir(): ?string
    {
        return $this->posteAPourvoir;
    }

    public function setPosteAPourvoir(?string $posteAPourvoir): self
    {
        $this->posteAPourvoir = $posteAPourvoir;

        return $this;
    }

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(?int $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getNombrePoste(): ?int
    {
        return $this->nombrePoste;
    }

    public function setNombrePoste(?int $nombrePoste): self
    {
        $this->nombrePoste = $nombrePoste;

        return $this;
    }

    public function getProprietaire(): ?Entreprise
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Entreprise $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addAnnonce($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeAnnonce($this);
        }

        return $this;
    }

    /**
     * @return Collection|Postulation[]
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Postulation $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->setAnnonce($this);
        }

        return $this;
    }

    public function removeCandidature(Postulation $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getAnnonce() === $this) {
                $candidature->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * @return Collection|Signaler[]
     */
    public function getSignales(): Collection
    {
        return $this->signales;
    }

    public function addSignale(Signaler $signale): self
    {
        if (!$this->signales->contains($signale)) {
            $this->signales[] = $signale;
            $signale->setAnnonce($this);
        }

        return $this;
    }

    public function removeSignale(Signaler $signale): self
    {
        if ($this->signales->removeElement($signale)) {
            // set the owning side to null (unless already changed)
            if ($signale->getAnnonce() === $this) {
                $signale->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getTypeContrat()
    {
        return $this->typeContrat;
    }

    public function setTypeContrat($typeContrat): self
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }
}
