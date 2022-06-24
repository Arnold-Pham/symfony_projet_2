<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623172920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, membre_id INTEGER DEFAULT NULL, vehicule_id INTEGER DEFAULT NULL, date_heure_depart DATETIME NOT NULL, date_heure_fin DATETIME NOT NULL, prix_total INTEGER DEFAULT NULL, date_enregistrement DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D6A99F74A ON commande (membre_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D4A4A3511 ON commande (vehicule_id)');
        $this->addSql('CREATE TABLE "membre" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pseudo VARCHAR(20) NOT NULL, password VARCHAR(60) NOT NULL, civilite VARCHAR(1) NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, email VARCHAR(180) NOT NULL, statut INTEGER NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , date_enregistrement DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6B4FB2986CC499D ON "membre" (pseudo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6B4FB29E7927C74 ON "membre" (email)');
        $this->addSql('CREATE TABLE vehicule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, marque VARCHAR(50) NOT NULL, modele VARCHAR(50) NOT NULL, description CLOB DEFAULT NULL, photo VARCHAR(200) DEFAULT NULL, prix_journalier INTEGER NOT NULL, date_enregistrement DATETIME NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE "membre"');
        $this->addSql('DROP TABLE vehicule');
    }
}
