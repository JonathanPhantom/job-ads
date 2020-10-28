<?php

namespace App\Entity;

use App\Repository\TypeContratRepository;
use Elao\Enum\Enum;
use Elao\Enum\AutoDiscoveredValuesTrait;


final class TypeContrat extends Enum
{
    use AutoDiscoveredValuesTrait;

    const Stage = "Stage";
    const CDI = "CDI";
    const CDD = "CDD";
}
