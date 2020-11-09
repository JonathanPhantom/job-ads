<?php

namespace App\Entity;




class ContactEntretien
{


    /**
     * @var \DateTime|null
     */
    private $dateEntretien;

    /**
     *
     * @var string
     */
    private $heureEntretien;

    /**
     * @return \DateTime|null
     */
    public function getDateEntretien(): ?\DateTime
    {
        return $this->dateEntretien;
    }

    /**
     * @param \DateTime|null $dateEntretien
     * @return ContactEntretien
     */
    public function setDateEntretien(?\DateTime $dateEntretien): ContactEntretien
    {
        $this->dateEntretien = $dateEntretien;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeureEntretien(): string
    {
        return $this->heureEntretien;
    }

    /**
     * @param string $heureEntretien
     * @return ContactEntretien
     */
    public function setHeureEntretien(string $heureEntretien): ContactEntretien
    {
        $this->heureEntretien = $heureEntretien;
        return $this;
    }




}
