<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210222175321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_system ADD username VARCHAR(180) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD nom VARCHAR(100) NOT NULL, ADD prenom VARCHAR(100) NOT NULL, ADD email VARCHAR(100) NOT NULL, ADD telephone VARCHAR(100) NOT NULL, ADD photo LONGBLOB NOT NULL, ADD archivage TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_94852072F85E0677 ON admin_system (username)');
        $this->addSql('ALTER TABLE caissier ADD username VARCHAR(180) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD nom VARCHAR(100) NOT NULL, ADD prenom VARCHAR(100) NOT NULL, ADD email VARCHAR(100) NOT NULL, ADD telephone VARCHAR(100) NOT NULL, ADD photo LONGBLOB NOT NULL, ADD archivage TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F038BC2F85E0677 ON caissier (username)');
        $this->addSql('ALTER TABLE gestion_agence_partenaire ADD username VARCHAR(180) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD nom VARCHAR(100) NOT NULL, ADD prenom VARCHAR(100) NOT NULL, ADD email VARCHAR(100) NOT NULL, ADD telephone VARCHAR(100) NOT NULL, ADD photo LONGBLOB NOT NULL, ADD archivage TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F34FFB7FF85E0677 ON gestion_agence_partenaire (username)');
        $this->addSql('ALTER TABLE user_agence_partenaire ADD username VARCHAR(180) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD nom VARCHAR(100) NOT NULL, ADD prenom VARCHAR(100) NOT NULL, ADD email VARCHAR(100) NOT NULL, ADD telephone VARCHAR(100) NOT NULL, ADD photo LONGBLOB NOT NULL, ADD archivage TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E0FCD87F85E0677 ON user_agence_partenaire (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_94852072F85E0677 ON admin_system');
        $this->addSql('ALTER TABLE admin_system DROP username, DROP password, DROP nom, DROP prenom, DROP email, DROP telephone, DROP photo, DROP archivage');
        $this->addSql('DROP INDEX UNIQ_1F038BC2F85E0677 ON caissier');
        $this->addSql('ALTER TABLE caissier DROP username, DROP password, DROP nom, DROP prenom, DROP email, DROP telephone, DROP photo, DROP archivage');
        $this->addSql('DROP INDEX UNIQ_F34FFB7FF85E0677 ON gestion_agence_partenaire');
        $this->addSql('ALTER TABLE gestion_agence_partenaire DROP username, DROP password, DROP nom, DROP prenom, DROP email, DROP telephone, DROP photo, DROP archivage');
        $this->addSql('DROP INDEX UNIQ_E0FCD87F85E0677 ON user_agence_partenaire');
        $this->addSql('ALTER TABLE user_agence_partenaire DROP username, DROP password, DROP nom, DROP prenom, DROP email, DROP telephone, DROP photo, DROP archivage');
    }
}
