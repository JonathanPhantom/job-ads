<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106173115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces ADD domaine_etudes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP domaine_etude');
        $this->addSql('ALTER TABLE cv ADD annee_experience VARCHAR(255) NOT NULL COMMENT \'(DC2Type:anneeExperience)\', ADD salaire INT DEFAULT NULL, ADD statut VARCHAR(255) NOT NULL COMMENT \'(DC2Type:statut)\'');
        $this->addSql('ALTER TABLE experience_professionnelle ADD niveau_poste VARCHAR(255) NOT NULL COMMENT \'(DC2Type:niveauDePoste)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces ADD domaine_etude VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:domaineEtude)\', DROP domaine_etudes');
        $this->addSql('ALTER TABLE cv DROP annee_experience, DROP salaire, DROP statut');
        $this->addSql('ALTER TABLE experience_professionnelle DROP niveau_poste');
    }
}
