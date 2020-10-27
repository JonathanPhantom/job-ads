<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027134805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creation of categorie entity and relations between entities';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_annonce (categorie_id INT NOT NULL, annonce_id INT NOT NULL, INDEX IDX_A9D63D47BCF5E72D (categorie_id), INDEX IDX_A9D63D478805AB2F (annonce_id), PRIMARY KEY(categorie_id, annonce_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise_candidat (entreprise_id INT NOT NULL, candidat_id INT NOT NULL, INDEX IDX_3865B2F4A4AEAFEA (entreprise_id), INDEX IDX_3865B2F48D0EB82 (candidat_id), PRIMARY KEY(entreprise_id, candidat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, candidat_id INT NOT NULL, date_postulation DATE NOT NULL, INDEX IDX_DA7D4E9B8805AB2F (annonce_id), INDEX IDX_DA7D4E9B8D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_annonce ADD CONSTRAINT FK_A9D63D47BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_annonce ADD CONSTRAINT FK_A9D63D478805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_candidat ADD CONSTRAINT FK_3865B2F4A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_candidat ADD CONSTRAINT FK_3865B2F48D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE annonce ADD proprietaire_id INT NOT NULL, ADD nombre_poste INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E576C50E4A FOREIGN KEY (proprietaire_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_F65593E576C50E4A ON annonce (proprietaire_id)');
        $this->addSql('ALTER TABLE candidat ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_6AB5B471A4AEAFEA ON candidat (entreprise_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_annonce DROP FOREIGN KEY FK_A9D63D47BCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_annonce');
        $this->addSql('DROP TABLE entreprise_candidat');
        $this->addSql('DROP TABLE postulation');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E576C50E4A');
        $this->addSql('DROP INDEX IDX_F65593E576C50E4A ON annonce');
        $this->addSql('ALTER TABLE annonce DROP proprietaire_id, DROP nombre_poste');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471A4AEAFEA');
        $this->addSql('DROP INDEX IDX_6AB5B471A4AEAFEA ON candidat');
        $this->addSql('ALTER TABLE candidat DROP entreprise_id');
    }
}
