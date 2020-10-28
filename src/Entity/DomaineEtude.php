<?php

namespace App\Entity;



use Elao\Enum\Enum;

final class DomaineEtude extends Enum
{
    const Informatique = 'Informatique';
    const GenieCivil = 'Génie Civil';
    const Biologie = 'Biologie';
    const Medecine = 'Medecine';
    const Gestion = 'Gestion';
    const Architecture = 'Architecture';
    const LangueLettre = 'Langues et Lettres';
    const ArtCultureDesignMode = 'Art, Culture, Desing et Mode';
    const EnvironnementScienceTerre = "Environnement et Science de la terre";
    const Chimie = 'Chimie';
    const AgricultureAgroAlimentaire = 'Agriculture, AgroAlimentaire';
    const Droit = 'Droit';
    const Physique = 'Physique';
    const CommunicationJournalisme = 'Communication, Journalisme';
    const ScienceIngenieur = "Science de l'ingénieur";
    const ScienceEducation = "Science de l'éducation";
    const ScienceHumaineSocial = "Science humaine et sociale";
    const Sport = 'Sport';
    const Tourisme = 'Tourisme';
    const HotelleriRestauration = "Hôtellerie, Restauration";
    const TransportLogistique = "Transport et Logistique";
    const Urbanisme = "Urbanisme";
    const Commerce = "Commerce";
    const Management = 'Management';

    /**
     * @inheritDoc
     */
    public static function values(): array
    {
        return [
            self::Informatique,
            self::GenieCivil,
            self::Biologie,
            self::Medecine,
            self::Gestion,
            self::Architecture,
            self::LangueLettre,
            self::ArtCultureDesignMode,
            self::Chimie,
            self::AgricultureAgroAlimentaire,
            self::Droit,
            self::Physique,
            self::CommunicationJournalisme,
            self::ScienceIngenieur,
            self::ScienceEducation,
            self::ScienceHumaineSocial,
            self::Sport,
            self::Tourisme,
            self::HotelleriRestauration,
            self::TransportLogistique,
            self::EnvironnementScienceTerre,
            self::Urbanisme,
            self::Commerce,
            self::Management,
        ];
    }
}
