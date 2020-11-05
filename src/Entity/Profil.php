<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ORM\Table(name="profils")
 * @Vich\Uploadable
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $competences;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $anneeExperience;

    //mise en place du cv

    /**
     * @Vich\UploadableField(mapping="cv_files", fileNameProperty="cvName")
     * @var File|null
     */
    private ?File $cvFile;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private string $cvName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;
    //fin mise en place

    /**
     * @ORM\Column(type="domaineEtude")
     */
    private $domaineEtudeProfil;

    /**
     * @ORM\Column(type="typeContrat")
     */
    private $typeContrat;

    /**
     * @ORM\ManyToOne(targetEntity=Candidat::class, inversedBy="profils")
     * @ORM\JoinColumn(nullable=false)
     */
    private $candidat;

    /**
     * @ORM\OneToMany(targetEntity=Diplome::class, mappedBy="profil", cascade={"persist"})
     *
     */
    private $diplomes;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isPrincipal;

    public function __construct()
    {
        $this->diplomes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * @param mixed $competences
     * @return Profil
     */
    public function setCompetences($competences)
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

    /**
     * @return File|null
     */
    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    /**
     * @param File|null $cvFile
     * @return Profil
     * @throws \Exception
     */
    public function setCvFile(?File $cvFile): Profil
    {
        $this->cvFile = $cvFile;
        if ($this->cvFile instanceof UploadedFile){
            $this->updateAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getCvName(): ?string
    {
        return $this->cvName;
    }

    /**
     * @param string|null $cvName
     * @return Profil
     */
    public function setCvName(?string $cvName): Profil
    {
        $this->cvName = $cvName;
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
     * @return Profil
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDomaineEtudeProfil()
    {
        return $this->domaineEtudeProfil;
    }

    /**
     * @param mixed $domaineEtudeProfil
     * @return Profil
     */
    public function setDomaineEtudeProfil($domaineEtudeProfil)
    {
        $this->domaineEtudeProfil = $domaineEtudeProfil;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeContrat()
    {
        return $this->typeContrat;
    }

    /**
     * @param mixed $typeContrat
     * @return Profil
     */
    public function setTypeContrat($typeContrat)
    {
        $this->typeContrat = $typeContrat;
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
     * @return Collection|Diplome[]
     */
    public function getDiplomes(): Collection
    {
        return $this->diplomes;
    }

    public function addDiplome(Diplome $diplome): self
    {
        if (!$this->diplomes->contains($diplome)) {
            $this->diplomes[] = $diplome;
            $diplome->setProfil($this);
        }

        return $this;
    }

    public function removeDiplome(Diplome $diplome): self
    {
        if ($this->diplomes->removeElement($diplome)) {
            // set the owning side to null (unless already changed)
            if ($diplome->getProfil() === $this) {
                $diplome->setProfil(null);
            }
        }

        return $this;
    }

    public function getIsPrincipal(): ?bool
    {
        return $this->isPrincipal;
    }

    public function setIsPrincipal(bool $isPrincipal): self
    {
        $this->isPrincipal = $isPrincipal;

        return $this;
    }




}
