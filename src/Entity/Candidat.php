<?php

namespace App\Entity;

use App\Repository\CandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidatRepository::class)
 * @ORM\Table(name="candidats")
 */
class Candidat extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $dateNaissance;


    /**
     * @ORM\Column(type="localites")
     */
    private $localite;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="candidats")
     */
    private ?Entreprise $entreprise;

    /**
     * @ORM\ManyToMany(targetEntity=Entreprise::class, mappedBy="candidatsRecrutes")
     */
    private ArrayCollection $entreprisesRecruteurs;

    /**
     * @ORM\OneToMany(targetEntity=Postulation::class, mappedBy="candidat", orphanRemoval=true)
     */
    private ArrayCollection $candidatures;


    /**
     * @ORM\OneToMany(targetEntity=Signaler::class, mappedBy="candidat")
     */
    private ArrayCollection $annonceSignales;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private array $emailsPersonnels = [];

    /**
     * @ORM\OneToMany(targetEntity=Cv::class, mappedBy="candidat", orphanRemoval=true)
     */
    private ArrayCollection $mesCvs;

    public function __construct()
    {
        $this->entreprisesRecruteurs = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
        $this->annonceSignales = new ArrayCollection();
        $this->mesCvs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocalite()
    {
        return $this->localite;
    }

    /**
     * @param mixed $localite
     * @return Candidat
     */
    public function setLocalite($localite)
    {
        $this->localite = $localite;
        return $this;
    }



    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * @return Collection|Entreprise[]
     */
    public function getEntreprisesRecruteurs(): Collection
    {
        return $this->entreprisesRecruteurs;
    }

    public function addEntreprisesRecruteur(Entreprise $entreprisesRecruteur): self
    {
        if (!$this->entreprisesRecruteurs->contains($entreprisesRecruteur)) {
            $this->entreprisesRecruteurs[] = $entreprisesRecruteur;
            $entreprisesRecruteur->addCandidatsRecrute($this);
        }

        return $this;
    }

    public function removeEntreprisesRecruteur(Entreprise $entreprisesRecruteur): self
    {
        if ($this->entreprisesRecruteurs->removeElement($entreprisesRecruteur)) {
            $entreprisesRecruteur->removeCandidatsRecrute($this);
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
            $candidature->setCandidat($this);
        }

        return $this;
    }

    public function removeCandidature(Postulation $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getCandidat() === $this) {
                $candidature->setCandidat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Signaler[]
     */
    public function getAnnonceSignales(): Collection
    {
        return $this->annonceSignales;
    }

    public function addAnnonceSignale(Signaler $annonceSignale): self
    {
        if (!$this->annonceSignales->contains($annonceSignale)) {
            $this->annonceSignales[] = $annonceSignale;
            $annonceSignale->setCandidat($this);
        }

        return $this;
    }

    public function removeAnnonceSignale(Signaler $annonceSignale): self
    {
        if ($this->annonceSignales->removeElement($annonceSignale)) {
            // set the owning side to null (unless already changed)
            if ($annonceSignale->getCandidat() === $this) {
                $annonceSignale->setCandidat(null);
            }
        }

        return $this;
    }

    public function getEmailsPersonnels(): ?array
    {
        return $this->emailsPersonnels;
    }

    public function setEmailsPersonnels(?array $emailsPersonnels): self
    {
        $this->emailsPersonnels = $emailsPersonnels;

        return $this;
    }

    /**
     * @return Collection|Cv[]
     */
    public function getMesCvs(): Collection
    {
        return $this->mesCvs;
    }

    public function addMesCv(Cv $mesCv): self
    {
        if (!$this->mesCvs->contains($mesCv)) {
            $this->mesCvs[] = $mesCv;
            $mesCv->setCandidat($this);
        }

        return $this;
    }

    public function removeMesCv(Cv $mesCv): self
    {
        if ($this->mesCvs->removeElement($mesCv)) {
            // set the owning side to null (unless already changed)
            if ($mesCv->getCandidat() === $this) {
                $mesCv->setCandidat(null);
            }
        }

        return $this;
    }



}
