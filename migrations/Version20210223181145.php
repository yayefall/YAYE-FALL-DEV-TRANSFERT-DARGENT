<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223181145 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, nom VARCHAR(150) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(100) NOT NULL, archivage TINYINT(1) NOT NULL, INDEX IDX_64C19AA967B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom_client VARCHAR(255) NOT NULL, nom_beneficiaire VARCHAR(255) NOT NULL, cniclient VARCHAR(255) NOT NULL, cnibeneficiaire VARCHAR(255) NOT NULL, telephone_client VARCHAR(255) NOT NULL, telephone_beneficiaire VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, agences_id INT DEFAULT NULL, users_id INT DEFAULT NULL, code VARCHAR(100) NOT NULL, montant INT NOT NULL, creat_at DATETIME NOT NULL, archivage TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_CFF652609917E4AB (agences_id), INDEX IDX_CFF6526067B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profils (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(40) NOT NULL, archivage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, clients_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, montant INT NOT NULL, creat_at DATETIME NOT NULL, type_transaction VARCHAR(100) NOT NULL, part_etat INT NOT NULL, part_entreprise INT NOT NULL, part_agent_retrait INT NOT NULL, part_agent_depot INT NOT NULL, archivage TINYINT(1) NOT NULL, INDEX IDX_EAA81A4C67B3B43D (users_id), UNIQUE INDEX UNIQ_EAA81A4CAB014612 (clients_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, profil_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, telephone VARCHAR(100) NOT NULL, photo LONGBLOB NOT NULL, archivage TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649275ED078 (profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA967B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF652609917E4AB FOREIGN KEY (agences_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526067B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C67B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CAB014612 FOREIGN KEY (clients_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profils (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF652609917E4AB');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CAB014612');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA967B3B43D');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526067B3B43D');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C67B3B43D');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE profils');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE `user`');
    }
}
