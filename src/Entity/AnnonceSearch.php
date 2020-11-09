<?php

namespace App\Entity;

use App\Repository\SearchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


class AnnonceSearch
{
    /**
     * @var
     */
    private $titreAnnonce;

    /**
     * @var Localites|null
     */
    private $localites;

    /**
     * @var DomaineEtude|null
     */
    private $domaineEtude;

    /**
     * @var TypeContrat|null
     */
    private $typeContrat;

    /**
     * @var NiveauFormation|null
     */
    private $niveauFormation;

    /**
     * @return mixed
     */
    public function getTitreAnnonce()
    {
        return $this->titreAnnonce;
    }

    /**
     * @param mixed $titreAnnonce
     */
    public function setTitreAnnonce($titreAnnonce): void
    {
        $this->titreAnnonce = $titreAnnonce;
    }

    /**
     * @return Localites|null
     */
    public function getLocalites(): ?Localites
    {
        return $this->localites;
    }

    /**
     * @param Localites|null $localites
     * @return AnnonceSearch
     */
    public function setLocalites(?Localites $localites): AnnonceSearch
    {
        $this->localites = $localites;
        return $this;
    }

    /**
     * @return DomaineEtude|null
     */
    public function getDomaineEtude(): ?DomaineEtude
    {
        return $this->domaineEtude;
    }

    /**
     * @param DomaineEtude|null $domaineEtude
     * @return AnnonceSearch
     */
    public function setDomaineEtude(?DomaineEtude $domaineEtude): AnnonceSearch
    {
        $this->domaineEtude = $domaineEtude;
        return $this;
    }

    /**
     * @return TypeContrat|null
     */
    public function getTypeContrat(): ?TypeContrat
    {
        return $this->typeContrat;
    }

    /**
     * @param TypeContrat|null $typeContrat
     * @return AnnonceSearch
     */
    public function setTypeContrat(?TypeContrat $typeContrat): AnnonceSearch
    {
        $this->typeContrat = $typeContrat;
        return $this;
    }

    /**
     * @return NiveauFormation|null
     */
    public function getNiveauFormation(): ?NiveauFormation
    {
        return $this->niveauFormation;
    }

    /**
     * @param NiveauFormation|null $niveauFormation
     * @return AnnonceSearch
     */
    public function setNiveauFormation(?NiveauFormation $niveauFormation): AnnonceSearch
    {
        $this->niveauFormation = $niveauFormation;
        return $this;
    }


}
