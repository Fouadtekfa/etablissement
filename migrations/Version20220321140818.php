<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321140818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, etablissement_id INT DEFAULT NULL, auteur VARCHAR(255) NOT NULL, date_commentaire DATETIME NOT NULL, commentaire LONGTEXT NOT NULL, note INT NOT NULL, INDEX IDX_D9BEC0C4FF631228 (etablissement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, appellation_officielle VARCHAR(255) NOT NULL, denomination_principale VARCHAR(255) NOT NULL, secteur VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, adresse VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, code_departement VARCHAR(255) NOT NULL, commune VARCHAR(255) NOT NULL, code_commune VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, code_region VARCHAR(255) NOT NULL, academie VARCHAR(255) NOT NULL, code_academie VARCHAR(255) NOT NULL, date_ouverture DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4FF631228');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
