<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201109093823 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postutlations ADD cv_envoye_id INT NOT NULL');
        $this->addSql('ALTER TABLE postutlations ADD CONSTRAINT FK_51312FC5BE248AB3 FOREIGN KEY (cv_envoye_id) REFERENCES cv (id)');
        $this->addSql('CREATE INDEX IDX_51312FC5BE248AB3 ON postutlations (cv_envoye_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postutlations DROP FOREIGN KEY FK_51312FC5BE248AB3');
        $this->addSql('DROP INDEX IDX_51312FC5BE248AB3 ON postutlations');
        $this->addSql('ALTER TABLE postutlations DROP cv_envoye_id');
    }
}
