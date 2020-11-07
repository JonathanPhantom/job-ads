<?php

namespace App\Entity;

use App\Repository\CandidatSearchRepository;
use Doctrine\ORM\Mapping as ORM;


class CandidatSearch
{

    /**
     * @var string|null
     */
    private $nom;

    /**
     * @var Localites|null
     */
    private $localite;

    /**
     * @var DomaineEtude|null
     */
    private $domaineEtude;

    /**
     * @var NiveauFormation|null
     */
    private $niveauFormation;

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     * @return CandidatSearch
     */
    public function setNom(?string $nom): CandidatSearch
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return Localites|null
     */
    public function getLocalite(): ?Localites
    {
        return $this->localite;
    }

    /**
     * @param Localites|null $localite
     * @return CandidatSearch
     */
    public function setLocalite(?Localites $localite): CandidatSearch
    {
        $this->localite = $localite;
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
     * @return CandidatSearch
     */
    public function setDomaineEtude(?DomaineEtude $domaineEtude): CandidatSearch
    {
        $this->domaineEtude = $domaineEtude;
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
     * @return CandidatSearch
     */
    public function setNiveauFormation(?NiveauFormation $niveauFormation): CandidatSearch
    {
        $this->niveauFormation = $niveauFormation;
        return $this;
    }





}
