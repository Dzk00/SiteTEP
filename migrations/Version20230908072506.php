<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908072506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message VARCHAR(400) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adherents ADD stage_toussaint_id INT DEFAULT NULL, ADD stage_hiver_id INT DEFAULT NULL, ADD stage_paques_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE adherents ADD CONSTRAINT FK_562C7DA37D4F3EF8 FOREIGN KEY (stage_toussaint_id) REFERENCES stages_toussaint (id)');
        $this->addSql('ALTER TABLE adherents ADD CONSTRAINT FK_562C7DA3A47ACBE8 FOREIGN KEY (stage_hiver_id) REFERENCES stages_hiver (id)');
        $this->addSql('ALTER TABLE adherents ADD CONSTRAINT FK_562C7DA3994821FF FOREIGN KEY (stage_paques_id) REFERENCES stages_paques (id)');
        $this->addSql('CREATE INDEX IDX_562C7DA37D4F3EF8 ON adherents (stage_toussaint_id)');
        $this->addSql('CREATE INDEX IDX_562C7DA3A47ACBE8 ON adherents (stage_hiver_id)');
        $this->addSql('CREATE INDEX IDX_562C7DA3994821FF ON adherents (stage_paques_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contact');
        $this->addSql('ALTER TABLE adherents DROP FOREIGN KEY FK_562C7DA37D4F3EF8');
        $this->addSql('ALTER TABLE adherents DROP FOREIGN KEY FK_562C7DA3A47ACBE8');
        $this->addSql('ALTER TABLE adherents DROP FOREIGN KEY FK_562C7DA3994821FF');
        $this->addSql('DROP INDEX IDX_562C7DA37D4F3EF8 ON adherents');
        $this->addSql('DROP INDEX IDX_562C7DA3A47ACBE8 ON adherents');
        $this->addSql('DROP INDEX IDX_562C7DA3994821FF ON adherents');
        $this->addSql('ALTER TABLE adherents DROP stage_toussaint_id, DROP stage_hiver_id, DROP stage_paques_id');
    }
}
