<?php

namespace App\Entity;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\Enum;


final class Statut extends Enum
{

    use AutoDiscoveredValuesTrait;

    const SansEmploi = "Sans emploi";
    const Enposte = "En poste";
    const finContrat = "En fin de contrat";
}
