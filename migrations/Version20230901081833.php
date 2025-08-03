<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230901081833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adherents (id INT AUTO_INCREMENT NOT NULL, cours_ad_id INT NOT NULL, nom_ad VARCHAR(255) NOT NULL, prenom_ad VARCHAR(255) NOT NULL, adresse_ad VARCHAR(255) DEFAULT NULL, code_postal_ad VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, mail_ad VARCHAR(255) NOT NULL, date_naissance_ad DATE NOT NULL, tel_ad VARCHAR(255) NOT NULL, tel_pere_ad VARCHAR(255) DEFAULT NULL, tel_mere_ad VARCHAR(255) DEFAULT NULL, tel_secours_ad VARCHAR(255) DEFAULT NULL, autorisation_urgence TINYINT(1) NOT NULL, vaccins_ad TINYINT(1) NOT NULL, antecedents_medicaux_ad VARCHAR(255) DEFAULT NULL, droit_image_ad TINYINT(1) NOT NULL, photo_ad VARCHAR(255) DEFAULT NULL, INDEX IDX_562C7DA37F525C40 (cours_ad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adherents ADD CONSTRAINT FK_562C7DA37F525C40 FOREIGN KEY (cours_ad_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE inscription_annuelle DROP FOREIGN KEY FK_B116B2CD7F525C40');
        $this->addSql('DROP TABLE inscription_annuelle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription_annuelle (id INT AUTO_INCREMENT NOT NULL, cours_ad_id INT NOT NULL, nom_ad VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom_ad VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, adresse_ad VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, code_postal_ad VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mail_ad VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_naissance_ad DATE NOT NULL, tel_ad VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, tel_pere_ad VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, tel_mere_ad VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, tel_secours_ad VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, autorisation_urgence TINYINT(1) NOT NULL, vaccins_ad TINYINT(1) NOT NULL, antecedents_medicaux_ad VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, droit_image_ad TINYINT(1) NOT NULL, photo_ad VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_B116B2CD7F525C40 (cours_ad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE inscription_annuelle ADD CONSTRAINT FK_B116B2CD7F525C40 FOREIGN KEY (cours_ad_id) REFERENCES cours (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE adherents DROP FOREIGN KEY FK_562C7DA37F525C40');
        $this->addSql('DROP TABLE adherents');
    }
}
