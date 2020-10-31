<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File;
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
     * @ORM\Column(type="array", nullable=true)
     */
    private $competences = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $anneeExperience;

    //mise en place du cv

    /**
     * @Vich\UploadableField(mapping="cv_files", fileNameProperty="cvName")
     * @var File
     */
    private $cvFile;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $cvName;

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

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return File
     */
    public function getCvFile(): File
    {
        return $this->cvFile;
    }

    /**
     * @param File $cvFile
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
     * @param string $cvName
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




}
