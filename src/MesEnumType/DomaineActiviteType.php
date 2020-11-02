<?php


namespace App\MesEnumType;


use App\Entity\DomaineActivite;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class DomaineActiviteType extends AbstractEnumType
{

    const NAME = 'domaineActivite';

    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return DomaineActivite::class;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}