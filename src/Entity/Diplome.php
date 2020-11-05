<?php

namespace App\Entity;

use App\Repository\DiplomeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=DiplomeRepository::class)
 * @ORM\Table(name="diplomes")
 * @Vich\Uploadable
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
    private ?int $dateObtention;

    /**
     * @Vich\UploadableField(mapping="diplomes_files", fileNameProperty="justificatifName")
     * @var File|null
     */
    private ?File $justificatifFile;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private string $justificatifName;

    /**
     * @ORM\Column(type="niveauFormation")
     */
    private $niveau;

    /**
     * permettant d'utiliser vichUploader pour specfier le fichier mise à jour
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="diplomes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Profil $profil;


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


    //getters et setter pour les fichiers

    /**
     * @param File|null $justificatifFile
     * @return Diplome
     * @throws \Exception
     */
    public function setJustificatifFile(?File $justificatifFile): Diplome
    {
        $this->justificatifFile = $justificatifFile;
        if ($this->justificatifFile instanceof UploadedFile) {
            $this->updateAt = new \DateTime('now');
        }
        return $this;
    }
    /**
     * @return File|null
     */
    public function getJustificatifFile(): ?File
    {
        return $this->justificatifFile;
    }


    /**
     * @return string
     */
    public function getJustificatifName(): ?string
    {
        return $this->justificatifName;
    }

    /**
     * @param string|null $justificatifName
     * @return Diplome
     */
    public function setJustificatifName(?string $justificatifName): Diplome
    {
        $this->justificatifName = $justificatifName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * @param mixed $niveau
     */
    public function setNiveau($niveau): void
    {
        $this->niveau = $niveau;
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
     * @return Diplome
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    

}
