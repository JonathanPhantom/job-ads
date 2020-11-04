<?php

namespace App\Entity;

use App\Repository\SearchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


class Search
{

    /**
     * @var Localites[]|null
     */
    private $localites;

    /**
     * @var DomaineEtude[]|null
     */
    private $domaineEtude;

    /**
     * @var TypeContrat[]|null
     */
    private $typeContrat;

    /**
     * @var NiveauFormation[]|null
     */
    private $niveauEtude;

    /**
     * @return Localites[]|null
     */
    public function getLocalites(): ?array
    {
        return $this->localites;
    }

    /**
     * @param Localites[]|null $localites
     * @return Search
     */
    public function setLocalites(?array $localites): Search
    {
        $this->localites = $localites;
        return $this;
    }

    /**
     * @return DomaineEtude[]|null
     */
    public function getDomaineEtude(): ?array
    {
        return $this->domaineEtude;
    }

    /**
     * @param DomaineEtude[]|null $domaineEtude
     * @return Search
     */
    public function setDomaineEtude(?array $domaineEtude): Search
    {
        $this->domaineEtude = $domaineEtude;
        return $this;
    }

    /**
     * @return TypeContrat[]|null
     */
    public function getTypeContrat(): ?array
    {
        return $this->typeContrat;
    }

    /**
     * @param TypeContrat[]|null $typeContrat
     * @return Search
     */
    public function setTypeContrat(?array $typeContrat): Search
    {
        $this->typeContrat = $typeContrat;
        return $this;
    }

    /**
     * @return NiveauFormation[]|null
     */
    public function getNiveauEtude(): ?array
    {
        return $this->niveauEtude;
    }

    /**
     * @param NiveauFormation[]|null $niveauEtude
     * @return Search
     */
    public function setNiveauEtude(?array $niveauEtude): Search
    {
        $this->niveauEtude = $niveauEtude;
        return $this;
    }





}
