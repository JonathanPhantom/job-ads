<?php

namespace App\Entity;




use Elao\Enum\Enum;
use Elao\Enum\AutoDiscoveredValuesTrait;

final class NiveauFormation extends Enum
{
    use AutoDiscoveredValuesTrait;

    const DUT = "DUT";
    const DTS = "DTS";
    const DUES = "DUES";
    const DEUG = "DEUG";
    const BTS = "BTS";
    const BAC = "BAC";
    const Licence = "Licence";
    const Ingenieur = "Ingénieur";
    const nonDiplome = "Non Diplômé";
    const LicencePro = "Licence Pro";
    const Maitrise = "Maîtrise";
    const Master1 = "Master 1";
    const Master2Recherche = "Master 2 recherche";
    const Master2Pro = "Master 2 professionnel";
    const Doctorat = "Doctorat";
    const DST = "DST";

}
