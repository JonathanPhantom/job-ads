<?php


namespace App\MesEnumType;


use App\Entity\Motifs;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class MotifsType extends AbstractEnumType
{

    const NAME = 'motifs';

    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return Motifs::class;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}