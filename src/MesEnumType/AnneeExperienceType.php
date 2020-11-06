<?php


namespace App\MesEnumType;




use App\Entity\AnneeExperience;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class AnneeExperienceType extends AbstractEnumType
{

    const NAME = "anneeExperience";

    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return AnneeExperience::class;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }



}