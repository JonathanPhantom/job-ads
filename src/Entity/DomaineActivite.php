<?php

namespace App\Entity;


use Elao\Enum\Enum;
use Elao\Enum\AutoDiscoveredValuesTrait;

final class DomaineActivite extends Enum
{
   use AutoDiscoveredValuesTrait;

   const Agroalimentaire = "Agroalimentaire";
   const InformatiqueTelInternet = "Informatique, Télécom, Internet";
   const BanqueAssurFinance = "Banque, Assuranc, Finance";
   const BatimentImmobilier = "Bâtiment, Immobilier";
   const Chimie = "Chimie";
   const CommerceDistribution = "CommerceDistribution";
   const Electronique = "Electronique";
   const Energie = "Energie";
   const Industrie = "Industrie";
   const MinesMatieresPre = "Mines, Matières premières";
   const ImportExport = "Import Export";
   const FonctionPublicAdmin = "Fonction publique, Administration";
   const Services = "Services";
}
