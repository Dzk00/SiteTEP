<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908155411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adherents_stages (adherents_id INT NOT NULL, stages_id INT NOT NULL, INDEX IDX_FD39C87015364D07 (adherents_id), INDEX IDX_FD39C8708E55E70A (stages_id), PRIMARY KEY(adherents_id, stages_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adherents_stages ADD CONSTRAINT FK_FD39C87015364D07 FOREIGN KEY (adherents_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adherents_stages ADD CONSTRAINT FK_FD39C8708E55E70A FOREIGN KEY (stages_id) REFERENCES stages (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherents_stages DROP FOREIGN KEY FK_FD39C87015364D07');
        $this->addSql('ALTER TABLE adherents_stages DROP FOREIGN KEY FK_FD39C8708E55E70A');
        $this->addSql('DROP TABLE adherents_stages');
    }
}
