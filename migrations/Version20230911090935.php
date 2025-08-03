<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911090935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adherents_stages_hiver (adherents_id INT NOT NULL, stages_hiver_id INT NOT NULL, INDEX IDX_B7F3FDE715364D07 (adherents_id), INDEX IDX_B7F3FDE7E437539A (stages_hiver_id), PRIMARY KEY(adherents_id, stages_hiver_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adherents_stages_paques (adherents_id INT NOT NULL, stages_paques_id INT NOT NULL, INDEX IDX_7E509F4515364D07 (adherents_id), INDEX IDX_7E509F4527037C77 (stages_paques_id), PRIMARY KEY(adherents_id, stages_paques_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adherents_stages_toussaint (adherents_id INT NOT NULL, stages_toussaint_id INT NOT NULL, INDEX IDX_80722BC315364D07 (adherents_id), INDEX IDX_80722BC37C72CF7F (stages_toussaint_id), PRIMARY KEY(adherents_id, stages_toussaint_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adherents_stages_hiver ADD CONSTRAINT FK_B7F3FDE715364D07 FOREIGN KEY (adherents_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adherents_stages_hiver ADD CONSTRAINT FK_B7F3FDE7E437539A FOREIGN KEY (stages_hiver_id) REFERENCES stages_hiver (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adherents_stages_paques ADD CONSTRAINT FK_7E509F4515364D07 FOREIGN KEY (adherents_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adherents_stages_paques ADD CONSTRAINT FK_7E509F4527037C77 FOREIGN KEY (stages_paques_id) REFERENCES stages_paques (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adherents_stages_toussaint ADD CONSTRAINT FK_80722BC315364D07 FOREIGN KEY (adherents_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adherents_stages_toussaint ADD CONSTRAINT FK_80722BC37C72CF7F FOREIGN KEY (stages_toussaint_id) REFERENCES stages_toussaint (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherents_stages_hiver DROP FOREIGN KEY FK_B7F3FDE715364D07');
        $this->addSql('ALTER TABLE adherents_stages_hiver DROP FOREIGN KEY FK_B7F3FDE7E437539A');
        $this->addSql('ALTER TABLE adherents_stages_paques DROP FOREIGN KEY FK_7E509F4515364D07');
        $this->addSql('ALTER TABLE adherents_stages_paques DROP FOREIGN KEY FK_7E509F4527037C77');
        $this->addSql('ALTER TABLE adherents_stages_toussaint DROP FOREIGN KEY FK_80722BC315364D07');
        $this->addSql('ALTER TABLE adherents_stages_toussaint DROP FOREIGN KEY FK_80722BC37C72CF7F');
        $this->addSql('DROP TABLE adherents_stages_hiver');
        $this->addSql('DROP TABLE adherents_stages_paques');
        $this->addSql('DROP TABLE adherents_stages_toussaint');
    }
}
