<?php


namespace App\MesEnumType;


use App\Entity\Localites;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class LocalitesType extends AbstractEnumType
{

    const NAME = 'localites';

    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return Localites::class;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}