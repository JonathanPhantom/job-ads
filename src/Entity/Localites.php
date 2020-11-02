<?php

namespace App\Entity;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\Enum;


final class Localites extends Enum
{

    use AutoDiscoveredValuesTrait;

    const Dakar = 'Dakar';
    const Diourbel = 'Diourbel';
    const Fatick = 'Fatick';
    const Kaffine = 'Kaffine';
    const Kaolack = 'Kaolack';
    const Kedegoudou = 'Kédougou';
    const Kolda = 'Kolda';
    const Louga = 'Louga';
    const Matam = 'Matam';
    const SaintLouis = 'Saint-Louis';
    const Sedhiou = 'Sédhiou';
    const Tambacounda = 'Tambacounda';
    const Thies = 'Thiès';
    const Ziguinchor = 'Ziguinchor';

}
