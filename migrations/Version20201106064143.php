<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106064143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diplomes DROP FOREIGN KEY FK_8A81EFD1275ED078');
        $this->addSql('CREATE TABLE cv (id INT AUTO_INCREMENT NOT NULL, candidat_id INT NOT NULL, titre_cv VARCHAR(255) NOT NULL, secteur_etude_souhaite VARCHAR(255) NOT NULL COMMENT \'(DC2Type:domaineEtude)\', disponibilite TINYINT(1) DEFAULT NULL, date_disponibilite DATE DEFAULT NULL, competences LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_B66FFE928D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience_professionnelle (id INT AUTO_INCREMENT NOT NULL, cv_id INT DEFAULT NULL, titre_poste VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, description_experience LONGTEXT DEFAULT NULL, localite VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:localites)\', secteur_activite VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:domaineActivite)\', INDEX IDX_4FC854EFCFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE928D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidats (id)');
        $this->addSql('ALTER TABLE experience_professionnelle ADD CONSTRAINT FK_4FC854EFCFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('DROP TABLE profils');
        $this->addSql('ALTER TABLE candidats ADD emails_personnels LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP description, DROP adresse, DROP disponibilite, DROP date_disponibilite');
        $this->addSql('DROP INDEX IDX_8A81EFD1275ED078 ON diplomes');
        $this->addSql('ALTER TABLE diplomes ADD cv_id INT NOT NULL, ADD titre_formation VARCHAR(255) NOT NULL, ADD date_debut DATE NOT NULL, ADD date_fin DATE NOT NULL, ADD nom_etablissement VARCHAR(255) NOT NULL, ADD localite VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:localites)\', DROP profil_id, DROP date_obtention');
        $this->addSql('ALTER TABLE diplomes ADD CONSTRAINT FK_8A81EFD1CFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('CREATE INDEX IDX_8A81EFD1CFE419E2 ON diplomes (cv_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diplomes DROP FOREIGN KEY FK_8A81EFD1CFE419E2');
        $this->addSql('ALTER TABLE experience_professionnelle DROP FOREIGN KEY FK_4FC854EFCFE419E2');
        $this->addSql('CREATE TABLE profils (id INT AUTO_INCREMENT NOT NULL, candidat_id INT NOT NULL, competences VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, annee_experience INT NOT NULL, cv_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, update_at DATETIME NOT NULL, domaine_etude_profil VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:domaineEtude)\', type_contrat VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:typeContrat)\', is_principal TINYINT(1) NOT NULL, INDEX IDX_75831F5E8D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE profils ADD CONSTRAINT FK_75831F5E8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidats (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE experience_professionnelle');
        $this->addSql('ALTER TABLE candidats ADD description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD disponibilite TINYINT(1) NOT NULL, ADD date_disponibilite DATE DEFAULT NULL, DROP emails_personnels');
        $this->addSql('DROP INDEX IDX_8A81EFD1CFE419E2 ON diplomes');
        $this->addSql('ALTER TABLE diplomes ADD date_obtention INT NOT NULL, DROP titre_formation, DROP date_debut, DROP date_fin, DROP nom_etablissement, DROP localite, CHANGE cv_id profil_id INT NOT NULL');
        $this->addSql('ALTER TABLE diplomes ADD CONSTRAINT FK_8A81EFD1275ED078 FOREIGN KEY (profil_id) REFERENCES profils (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8A81EFD1275ED078 ON diplomes (profil_id)');
    }
}
