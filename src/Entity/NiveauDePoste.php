<?php

namespace App\Entity;


use Elao\Enum\Enum;
use Elao\Enum\AutoDiscoveredValuesTrait;


final class NiveauDePoste extends Enum
{

    use AutoDiscoveredValuesTrait;

    const StagiaireEtudiant = "Stagiaire / Etudiant";
    const JeuneDiplome = "Jeune diplômé(e)";
    const DebutantJunior = "Débutant / junior";
    const ResponsableEquipe = "Responsable d'équipe";
    const ManagerRespoDepart = "Manager / Responsable département";
    const CadreDirigeant = "Cadre dirigeant";
}
