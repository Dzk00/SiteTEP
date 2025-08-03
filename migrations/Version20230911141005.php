<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911141005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE titre_court titre_court VARCHAR(100) NOT NULL, CHANGE description_courte description_courte VARCHAR(255) NOT NULL, CHANGE description_longue_un description_longue_un VARCHAR(255) NOT NULL, CHANGE description_longue_2 description_longue_2 VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog CHANGE titre titre VARCHAR(60) NOT NULL, CHANGE titre_court titre_court VARCHAR(20) NOT NULL, CHANGE description_courte description_courte VARCHAR(250) NOT NULL, CHANGE description_longue_un description_longue_un VARCHAR(500) NOT NULL, CHANGE description_longue_2 description_longue_2 VARCHAR(500) NOT NULL');
    }
}
