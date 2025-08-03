<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905102304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherents DROP autorisation_urgence, DROP vaccins_ad, DROP droit_image_ad');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherents ADD autorisation_urgence TINYINT(1) NOT NULL, ADD vaccins_ad TINYINT(1) NOT NULL, ADD droit_image_ad TINYINT(1) NOT NULL');
    }
}
