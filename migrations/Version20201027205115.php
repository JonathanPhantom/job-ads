<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027205115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creation of tables';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnements (id INT AUTO_INCREMENT NOT NULL, nom_abonnement VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admins (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonces (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT NOT NULL, titre_annonce VARCHAR(255) NOT NULL, date_limite DATE NOT NULL, annee_experience INT NOT NULL, description LONGTEXT NOT NULL, poste_apourvoir VARCHAR(255) DEFAULT NULL, salaire INT DEFAULT NULL, nombre_poste INT DEFAULT NULL, INDEX IDX_CB988C6F76C50E4A (proprietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidats (id INT NOT NULL, entreprise_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, description LONGTEXT NOT NULL, adresse VARCHAR(255) NOT NULL, disponibilite TINYINT(1) NOT NULL, date_disponibilite DATE DEFAULT NULL, localite VARCHAR(255) NOT NULL, INDEX IDX_3C663B15A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_annonce (categorie_id INT NOT NULL, annonce_id INT NOT NULL, INDEX IDX_A9D63D47BCF5E72D (categorie_id), INDEX IDX_A9D63D478805AB2F (annonce_id), PRIMARY KEY(categorie_id, annonce_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diplomes (id INT AUTO_INCREMENT NOT NULL, date_obtention INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprises (id INT NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, email_contact VARCHAR(255) NOT NULL, nom_contact VARCHAR(255) NOT NULL, numero_contact VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, site_web VARCHAR(255) DEFAULT NULL, localite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise_candidat (entreprise_id INT NOT NULL, candidat_id INT NOT NULL, INDEX IDX_3865B2F4A4AEAFEA (entreprise_id), INDEX IDX_3865B2F48D0EB82 (candidat_id), PRIMARY KEY(entreprise_id, candidat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postutlations (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, candidat_id INT NOT NULL, date_postulation DATE NOT NULL, INDEX IDX_51312FC58805AB2F (annonce_id), INDEX IDX_51312FC58D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profils (id INT AUTO_INCREMENT NOT NULL, competences LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', annee_experience INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, acteur VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admins ADD CONSTRAINT FK_A2E0150FBF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES entreprises (id)');
        $this->addSql('ALTER TABLE candidats ADD CONSTRAINT FK_3C663B15A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprises (id)');
        $this->addSql('ALTER TABLE candidats ADD CONSTRAINT FK_3C663B15BF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_annonce ADD CONSTRAINT FK_A9D63D47BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_annonce ADD CONSTRAINT FK_A9D63D478805AB2F FOREIGN KEY (annonce_id) REFERENCES annonces (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprises ADD CONSTRAINT FK_56B1B7A9BF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_candidat ADD CONSTRAINT FK_3865B2F4A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprises (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_candidat ADD CONSTRAINT FK_3865B2F48D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidats (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postutlations ADD CONSTRAINT FK_51312FC58805AB2F FOREIGN KEY (annonce_id) REFERENCES annonces (id)');
        $this->addSql('ALTER TABLE postutlations ADD CONSTRAINT FK_51312FC58D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidats (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_annonce DROP FOREIGN KEY FK_A9D63D478805AB2F');
        $this->addSql('ALTER TABLE postutlations DROP FOREIGN KEY FK_51312FC58805AB2F');
        $this->addSql('ALTER TABLE entreprise_candidat DROP FOREIGN KEY FK_3865B2F48D0EB82');
        $this->addSql('ALTER TABLE postutlations DROP FOREIGN KEY FK_51312FC58D0EB82');
        $this->addSql('ALTER TABLE categorie_annonce DROP FOREIGN KEY FK_A9D63D47BCF5E72D');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F76C50E4A');
        $this->addSql('ALTER TABLE candidats DROP FOREIGN KEY FK_3C663B15A4AEAFEA');
        $this->addSql('ALTER TABLE entreprise_candidat DROP FOREIGN KEY FK_3865B2F4A4AEAFEA');
        $this->addSql('ALTER TABLE admins DROP FOREIGN KEY FK_A2E0150FBF396750');
        $this->addSql('ALTER TABLE candidats DROP FOREIGN KEY FK_3C663B15BF396750');
        $this->addSql('ALTER TABLE entreprises DROP FOREIGN KEY FK_56B1B7A9BF396750');
        $this->addSql('DROP TABLE abonnements');
        $this->addSql('DROP TABLE admins');
        $this->addSql('DROP TABLE annonces');
        $this->addSql('DROP TABLE candidats');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categorie_annonce');
        $this->addSql('DROP TABLE diplomes');
        $this->addSql('DROP TABLE entreprises');
        $this->addSql('DROP TABLE entreprise_candidat');
        $this->addSql('DROP TABLE postutlations');
        $this->addSql('DROP TABLE profils');
        $this->addSql('DROP TABLE users');
    }
}
