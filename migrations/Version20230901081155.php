<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230901081155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, nom_cours VARCHAR(255) NOT NULL, heure_cours VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_annuelle (id INT AUTO_INCREMENT NOT NULL, cours_ad_id INT NOT NULL, nom_ad VARCHAR(255) NOT NULL, prenom_ad VARCHAR(255) NOT NULL, adresse_ad VARCHAR(255) DEFAULT NULL, code_postal_ad VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, mail_ad VARCHAR(255) NOT NULL, date_naissance_ad DATE NOT NULL, tel_ad VARCHAR(255) NOT NULL, tel_pere_ad VARCHAR(255) DEFAULT NULL, tel_mere_ad VARCHAR(255) DEFAULT NULL, tel_secours_ad VARCHAR(255) DEFAULT NULL, autorisation_urgence TINYINT(1) NOT NULL, vaccins_ad TINYINT(1) NOT NULL, antecedents_medicaux_ad VARCHAR(255) DEFAULT NULL, droit_image_ad TINYINT(1) NOT NULL, photo_ad VARCHAR(255) DEFAULT NULL, INDEX IDX_B116B2CD7F525C40 (cours_ad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription_annuelle ADD CONSTRAINT FK_B116B2CD7F525C40 FOREIGN KEY (cours_ad_id) REFERENCES cours (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription_annuelle DROP FOREIGN KEY FK_B116B2CD7F525C40');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE inscription_annuelle');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
