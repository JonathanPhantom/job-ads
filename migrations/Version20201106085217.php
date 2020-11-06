<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106085217 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidats ADD adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cv ADD update_at DATETIME NOT NULL, ADD photo_profil VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE diplomes DROP domaine');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidats DROP adresse');
        $this->addSql('ALTER TABLE cv DROP update_at, DROP photo_profil');
        $this->addSql('ALTER TABLE diplomes ADD domaine VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:domaineEtude)\'');
    }
}
