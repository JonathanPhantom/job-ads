<?php

namespace App\Entity;

use App\Repository\CvRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @ORM\ManyToOne(targetEntity=Candidat::class, inversedBy="mesCvs",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Candidat $candidat;

    /**
     * @Vich\UploadableField(mapping="image_user", fileNameProperty="photoProfil")
     * @var File
     */
    private $photoProfilFile;

    //update pour gérer l'insertion des fichiers

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\Column(type="string",nullable=true)
     * @var string
     */
    private $photoProfil;

    /**
     * @ORM\Column(type="domaineEtude")
     */
    private $secteurEtudeSouhaite;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $disponibilite;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeInterface $dateDisponibilite;

    /**
     * @ORM\OneToMany(targetEntity=Diplome::class, mappedBy="cv", orphanRemoval=true)
     */
    private $formations;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private array $competences = [];

    /**
     * @ORM\OneToMany(targetEntity=ExperienceProfessionnelle::class, mappedBy="cv")
     */
    private $experiencesProfessionnelles;

    /**
     * @ORM\Column(type="anneeExperience")
     */
    private $anneeExperience;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $salaire;

    /**
     * @ORM\Column(type="statut")
     */
    private $statut;

    /**
     * @ORM\Column(type="niveauDePoste")
     */
    private $niveauPoste;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $langues = [];

    /**
     * @ORM\OneToMany(targetEntity=Postulation::class, mappedBy="cvEnvoye")
     */
    private $postulations;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->experiencesProfessionnelles = new ArrayCollection();
        $this->postulations = new ArrayCollection();
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

    /**
     * @return File
     */
    public function getPhotoProfilFile(): ?File
    {
        return $this->photoProfilFile;
    }

    /**
     * @param File $photoProfilFile
     * @return Cv
     * @throws \Exception
     */
    public function setPhotoProfilFile(File $photoProfilFile): Cv
    {
        $this->photoProfilFile = $photoProfilFile;
        if ($this->photoProfilFile instanceof UploadedFile) {
            $this->updateAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @param mixed $updateAt
     * @return Cv
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhotoProfil(): ?string
    {
        return $this->photoProfil;
    }

    /**
     * @param string $photoProfil
     * @return Cv
     */
    public function setPhotoProfil(string $photoProfil): Cv
    {
        $this->photoProfil = $photoProfil;
        return $this;
    }

    public function getSecteurEtudeSouhaite()
    {
        return $this->secteurEtudeSouhaite;
    }

    public function setSecteurEtudeSouhaite($secteurEtudeSouhaite): self
    {
        $this->secteurEtudeSouhaite = $secteurEtudeSouhaite;

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

    public function getDateDisponibilite(): ?DateTimeInterface
    {
        return $this->dateDisponibilite;
    }

    public function setDateDisponibilite(?DateTimeInterface $dateDisponibilite): self
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
    public function getExperiencesProfessionnelles(): Collection
    {
        return $this->experiencesProfessionnelles;
    }

    public function addExperiencesProfessionnelle(ExperienceProfessionnelle $experiencesProfessionnelle): self
    {
        if (!$this->experiencesProfessionnelles->contains($experiencesProfessionnelle)) {
            $this->experiencesProfessionnelles[] = $experiencesProfessionnelle;
            $experiencesProfessionnelle->setCv($this);
        }

        return $this;
    }

    public function removeExperiencesProfessionnelle(ExperienceProfessionnelle $experiencesProfessionnelle): self
    {
        if ($this->experiencesProfessionnelles->removeElement($experiencesProfessionnelle)) {
            // set the owning side to null (unless already changed)
            if ($experiencesProfessionnelle->getCv() === $this) {
                $experiencesProfessionnelle->setCv(null);
            }
        }

        return $this;
    }

    public function getAnneeExperience()
    {
        return $this->anneeExperience;
    }

    public function setAnneeExperience($anneeExperience): self
    {
        $this->anneeExperience = $anneeExperience;

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

    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut($statut): self
    {
        $this->statut = $statut;

        return $this;
    }
    public function getNiveauPoste()
    {
        return $this->niveauPoste;
    }

    public function setNiveauPoste($niveauPoste): self
    {
        $this->niveauPoste = $niveauPoste;

        return $this;
    }

    public function getLangues(): ?array
    {
        return $this->langues;
    }

    public function setLangues(?array $langues): self
    {
        $this->langues = $langues;

        return $this;
    }

    /**
     * @return Collection|Postulation[]
     */
    public function getPostulations(): Collection
    {
        return $this->postulations;
    }

    public function addPostulation(Postulation $postulation): self
    {
        if (!$this->postulations->contains($postulation)) {
            $this->postulations[] = $postulation;
            $postulation->setCvEnvoye($this);
        }

        return $this;
    }

    public function removePostulation(Postulation $postulation): self
    {
        if ($this->postulations->removeElement($postulation)) {
            // set the owning side to null (unless already changed)
            if ($postulation->getCvEnvoye() === $this) {
                $postulation->setCvEnvoye(null);
            }
        }

        return $this;
    }
}
