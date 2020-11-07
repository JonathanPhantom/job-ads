<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 * @ORM\Table(name="entreprises")
 */
class Entreprise extends User
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
    private ?string $nomEntreprise;

    /**
     * @ORM\Column(type="domaineActivite")
     */
    private $secteurActivite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $emailContact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nomContact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $numeroContact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $siteWeb;

    /**
     * @ORM\Column(type="localites")
     */
    private $localite;

    /**
     * @ORM\OneToMany(targetEntity=Candidat::class, mappedBy="entreprise")
     */
    private $candidats;

    /**
     * @ORM\ManyToMany(targetEntity=Candidat::class, inversedBy="entreprisesRecruteurs")
     */
    private $candidatsRecrutes;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="proprietaire", orphanRemoval=true)
     */
    private $annonces;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
        $this->candidatsRecrutes = new ArrayCollection();
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * Get the value of secteurActivite
     *
     * getSecteurActivite
     *
     * @return void
     */
    public function getSecteurActivite()
    {
        return $this->secteurActivite;
    }

    /**
     * Set the value of secteurActivite
     *
     * @return  self
     */
    public function setSecteurActivite($secteurActivite)
    {
        $this->secteurActivite = $secteurActivite;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->emailContact;
    }

    public function setEmailContact(string $emailContact): self
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    public function getNomContact(): ?string
    {
        return $this->nomContact;
    }

    public function setNomContact(string $nomContact): self
    {
        $this->nomContact = $nomContact;

        return $this;
    }

    public function getNumeroContact(): ?string
    {
        return $this->numeroContact;
    }

    public function setNumeroContact(string $numeroContact): self
    {
        $this->numeroContact = $numeroContact;

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

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

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
     * @return Entreprise
     */
    public function setLocalite($localite)
    {
        $this->localite = $localite;
        return $this;
    }


    /**
     * @return Collection|Candidat[]
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats[] = $candidat;
            $candidat->setEntreprise($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidats->removeElement($candidat)) {
            // set the owning side to null (unless already changed)
            if ($candidat->getEntreprise() === $this) {
                $candidat->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Candidat[]
     */
    public function getCandidatsRecrutes(): Collection
    {
        return $this->candidatsRecrutes;
    }

    public function addCandidatsRecrute(Candidat $candidatsRecrute): self
    {
        if (!$this->candidatsRecrutes->contains($candidatsRecrute)) {
            $this->candidatsRecrutes[] = $candidatsRecrute;
        }

        return $this;
    }

    public function removeCandidatsRecrute(Candidat $candidatsRecrute): self
    {
        $this->candidatsRecrutes->removeElement($candidatsRecrute);

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setProprietaire($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getProprietaire() === $this) {
                $annonce->setProprietaire(null);
            }
        }

        return $this;
    }
}
