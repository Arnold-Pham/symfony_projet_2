<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624072436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_6EEAA67D4A4A3511');
        $this->addSql('DROP INDEX IDX_6EEAA67D6A99F74A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commande AS SELECT id, membre_id, vehicule_id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement FROM commande');
        $this->addSql('DROP TABLE commande');
        $this->addSql('CREATE TABLE commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, membre_id INTEGER DEFAULT NULL, vehicule_id INTEGER DEFAULT NULL, date_heure_depart DATETIME NOT NULL, date_heure_fin DATETIME NOT NULL, prix_total INTEGER DEFAULT NULL, date_enregistrement DATETIME NOT NULL, CONSTRAINT FK_6EEAA67D6A99F74A FOREIGN KEY (membre_id) REFERENCES "membre" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6EEAA67D4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO commande (id, membre_id, vehicule_id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement) SELECT id, membre_id, vehicule_id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement FROM __temp__commande');
        $this->addSql('DROP TABLE __temp__commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67D4A4A3511 ON commande (vehicule_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D6A99F74A ON commande (membre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_6EEAA67D6A99F74A');
        $this->addSql('DROP INDEX IDX_6EEAA67D4A4A3511');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commande AS SELECT id, membre_id, vehicule_id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement FROM commande');
        $this->addSql('DROP TABLE commande');
        $this->addSql('CREATE TABLE commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, membre_id INTEGER DEFAULT NULL, vehicule_id INTEGER DEFAULT NULL, date_heure_depart DATETIME NOT NULL, date_heure_fin DATETIME NOT NULL, prix_total INTEGER DEFAULT NULL, date_enregistrement DATETIME NOT NULL)');
        $this->addSql('INSERT INTO commande (id, membre_id, vehicule_id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement) SELECT id, membre_id, vehicule_id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement FROM __temp__commande');
        $this->addSql('DROP TABLE __temp__commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67D6A99F74A ON commande (membre_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D4A4A3511 ON commande (vehicule_id)');
    }
}
