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
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disponibilite;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDisponibilite;

    /**
     * @ORM\Column(type="localites")
     */
    private $localite;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="candidats")
     */
    private $entreprise;

    /**
     * @ORM\ManyToMany(targetEntity=Entreprise::class, mappedBy="candidatsRecrutes")
     */
    private $entreprisesRecruteurs;

    /**
     * @ORM\OneToMany(targetEntity=Postulation::class, mappedBy="candidat", orphanRemoval=true)
     */
    private $candidatures;

    /**
     * @ORM\OneToMany(targetEntity=Profil::class, mappedBy="candidat", orphanRemoval=true)
     */
    private $profils;

    /**
     * @ORM\OneToMany(targetEntity=Signaler::class, mappedBy="candidat")
     */
    private $annonceSignales;

    public function __construct()
    {
        $this->entreprisesRecruteurs = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
        $this->profils = new ArrayCollection();
        $this->annonceSignales = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): self
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
     * @return Collection|Profil[]
     */
    public function getProfils(): Collection
    {
        return $this->profils;
    }

    public function addProfil(Profil $profil): self
    {
        if (!$this->profils->contains($profil)) {
            $this->profils[] = $profil;
            $profil->setCandidat($this);
        }

        return $this;
    }

    public function removeProfil(Profil $profil): self
    {
        if ($this->profils->removeElement($profil)) {
            // set the owning side to null (unless already changed)
            if ($profil->getCandidat() === $this) {
                $profil->setCandidat(null);
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



}
