<?php

namespace App\Entity;

use App\Repository\CvRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CvRepository::class)
 */
class Cv
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
    private ?string $titreCv;

    /**
     * @ORM\ManyToOne(targetEntity=Candidat::class, inversedBy="mesCvs")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Candidat $candidat;

    /**
     * @ORM\Column(type="domaineEtude")
     */
    private $SecteurEtudeSouhaite;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $disponibilite;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?\DateTimeInterface $dateDisponibilite;

    /**
     * @ORM\OneToMany(targetEntity=Diplome::class, mappedBy="cv", orphanRemoval=true)
     */
    private ArrayCollection $formations;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private array $competences = [];

    /**
     * @ORM\OneToMany(targetEntity=ExperienceProfessionnelle::class, mappedBy="cv")
     */
    private $experienecesProfessionnelles;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->experienecesProfessionnelles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreCv(): ?string
    {
        return $this->titreCv;
    }

    public function setTitreCv(string $titreCv): self
    {
        $this->titreCv = $titreCv;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getSecteurEtudeSouhaite()
    {
        return $this->SecteurEtudeSouhaite;
    }

    public function setSecteurEtudeSouhaite($SecteurEtudeSouhaite): self
    {
        $this->SecteurEtudeSouhaite = $SecteurEtudeSouhaite;

        return $this;
    }

    public function getDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?bool $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getDateDisponibilite(): ?\DateTimeInterface
    {
        return $this->dateDisponibilite;
    }

    public function setDateDisponibilite(?\DateTimeInterface $dateDisponibilite): self
    {
        $this->dateDisponibilite = $dateDisponibilite;

        return $this;
    }

    /**
     * @return Collection|Diplome[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Diplome $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setCv($this);
        }

        return $this;
    }

    public function removeFormation(Diplome $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getCv() === $this) {
                $formation->setCv(null);
            }
        }

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

    /**
     * @return Collection|ExperienceProfessionnelle[]
     */
    public function getExperienecesProfessionnelles(): Collection
    {
        return $this->experienecesProfessionnelles;
    }

    public function addExperienecesProfessionnelle(ExperienceProfessionnelle $experienecesProfessionnelle): self
    {
        if (!$this->experienecesProfessionnelles->contains($experienecesProfessionnelle)) {
            $this->experienecesProfessionnelles[] = $experienecesProfessionnelle;
            $experienecesProfessionnelle->setCv($this);
        }

        return $this;
    }

    public function removeExperienecesProfessionnelle(ExperienceProfessionnelle $experienecesProfessionnelle): self
    {
        if ($this->experienecesProfessionnelles->removeElement($experienecesProfessionnelle)) {
            // set the owning side to null (unless already changed)
            if ($experienecesProfessionnelle->getCv() === $this) {
                $experienecesProfessionnelle->setCv(null);
            }
        }

        return $this;
    }
}
