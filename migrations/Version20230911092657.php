<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911092657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stages_hiver ADD max TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE stages_paques ADD max TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE stages_toussaint ADD max TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stages_toussaint DROP max');
        $this->addSql('ALTER TABLE stages_paques DROP max');
        $this->addSql('ALTER TABLE stages_hiver DROP max');
    }
}
