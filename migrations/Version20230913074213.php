<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913074213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog CHANGE description_courte description_courte VARCHAR(275) NOT NULL, CHANGE description_longue_un description_longue_un VARCHAR(550) NOT NULL, CHANGE description_longue_2 description_longue_2 VARCHAR(550) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog CHANGE description_courte description_courte VARCHAR(255) NOT NULL, CHANGE description_longue_un description_longue_un VARCHAR(255) NOT NULL, CHANGE description_longue_2 description_longue_2 VARCHAR(255) NOT NULL');
    }
}
