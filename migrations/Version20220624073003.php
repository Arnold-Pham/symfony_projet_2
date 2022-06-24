<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624073003 extends AbstractMigration
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
        $this->addSql('CREATE TEMPORARY TABLE __temp__commande AS SELECT id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement FROM commande');
        $this->addSql('DROP TABLE commande');
        $this->addSql('CREATE TABLE commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, membre INTEGER DEFAULT NULL, vehicule INTEGER DEFAULT NULL, date_heure_depart DATETIME NOT NULL, date_heure_fin DATETIME NOT NULL, prix_total INTEGER DEFAULT NULL, date_enregistrement DATETIME NOT NULL, CONSTRAINT FK_6EEAA67DF6B4FB29 FOREIGN KEY (membre) REFERENCES "membre" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6EEAA67D292FFF1D FOREIGN KEY (vehicule) REFERENCES vehicule (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO commande (id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement) SELECT id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement FROM __temp__commande');
        $this->addSql('DROP TABLE __temp__commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67DF6B4FB29 ON commande (membre)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D292FFF1D ON commande (vehicule)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_6EEAA67DF6B4FB29');
        $this->addSql('DROP INDEX IDX_6EEAA67D292FFF1D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commande AS SELECT id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement FROM commande');
        $this->addSql('DROP TABLE commande');
        $this->addSql('CREATE TABLE commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_heure_depart DATETIME NOT NULL, date_heure_fin DATETIME NOT NULL, prix_total INTEGER DEFAULT NULL, date_enregistrement DATETIME NOT NULL, membre_id INTEGER DEFAULT NULL, vehicule_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO commande (id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement) SELECT id, date_heure_depart, date_heure_fin, prix_total, date_enregistrement FROM __temp__commande');
        $this->addSql('DROP TABLE __temp__commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67D4A4A3511 ON commande (vehicule_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D6A99F74A ON commande (membre_id)');
    }
}
