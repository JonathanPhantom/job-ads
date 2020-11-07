<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106133956 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cv ADD annee_experience VARCHAR(255) NOT NULL COMMENT \'(DC2Type:anneeExperience)\', ADD salaire INT DEFAULT NULL, ADD statut VARCHAR(255) NOT NULL COMMENT \'(DC2Type:statut)\'');
        $this->addSql('ALTER TABLE experience_professionnelle ADD niveau_poste VARCHAR(255) NOT NULL COMMENT \'(DC2Type:niveauDePoste)\'');
        $this->addSql('ALTER TABLE users CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cv DROP annee_experience, DROP salaire, DROP statut');
        $this->addSql('ALTER TABLE experience_professionnelle DROP niveau_poste');
        $this->addSql('ALTER TABLE users CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
