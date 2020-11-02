<?php

namespace App\Entity;

use Elao\Enum\Enum;
use Elao\Enum\AutoDiscoveredValuesTrait;


final class Motifs extends Enum
{

    use AutoDiscoveredValuesTrait;

    const Discrimination = 'Discrimination';
    const ContenuOffensant = 'Contenu offensant';
    const ArnaqueFraude = 'Arnaque/Fraude';
    const Autres = 'Autres';
}
