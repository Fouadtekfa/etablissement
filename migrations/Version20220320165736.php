<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220320165736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement ADD code_departement VARCHAR(255) NOT NULL, ADD code_commune VARCHAR(255) NOT NULL, ADD code_region VARCHAR(255) NOT NULL, ADD code_academie VARCHAR(255) NOT NULL, CHANGE date_ouverture date_ouverture DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement DROP code_departement, DROP code_commune, DROP code_region, DROP code_academie, CHANGE date_ouverture date_ouverture DATETIME NOT NULL');
    }
}
