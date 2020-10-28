<?php

namespace App\Entity;

use Elao\Enum\Enum;
use Elao\Enum\AutoDiscoveredValuesTrait;


final class TypeAbonnement extends Enum
{
    use AutoDiscoveredValuesTrait;

    const Gratuit = "Gratuit";
    const Standart = "Standart";
    const Premium = "Premium";
}
