<?php

namespace App\Entity;

use App\Repository\DiplomeRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
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
    private ?int $id;


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
     * @ORM\ManyToOne(targetEntity=Cv::class, inversedBy="formations")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Cv $cv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $titreFormation;

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
    private ?string $nomEtablissement;

    /**
     * @ORM\Column(type="localites", nullable=true)
     */
    private $localite;


    public function getId(): ?int
    {
        return $this->id;
    }


    //getters et setter pour les fichiers

    /**
     * @param File|null $justificatifFile
     * @return Diplome
     * @throws Exception
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
    
    public function getCv(): ?Cv
    {
        return $this->cv;
    }

    public function setCv(?Cv $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getTitreFormation(): ?string
    {
        return $this->titreFormation;
    }

    public function setTitreFormation(string $titreFormation): self
    {
        $this->titreFormation = $titreFormation;

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

    public function getNomEtablissement(): ?string
    {
        return $this->nomEtablissement;
    }

    public function setNomEtablissement(string $nomEtablissement): self
    {
        $this->nomEtablissement = $nomEtablissement;

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

    

}
