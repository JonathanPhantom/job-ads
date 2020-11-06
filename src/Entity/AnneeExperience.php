<?php

namespace App\Entity;

use Elao\Enum\Enum;
use Elao\Enum\AutoDiscoveredValuesTrait;


final class AnneeExperience extends Enum
{

   use AutoDiscoveredValuesTrait;

   const SansExperience = "Sans Expérience";
   const MoinsUnAN = "Moins d'un an";
   const UnAdeux = "1 à 2 ans";
   const TroisAcinq = "3 à 5 ans";
   const SixADix = "6 à 10 ans";
   const PlusDix = "Plus de 10 ans";
}
