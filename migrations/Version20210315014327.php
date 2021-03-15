<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210315014327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bloc_transaction (id INT AUTO_INCREMENT NOT NULL, clients_id INT NOT NULL, comptes_id INT NOT NULL, user_depot_id INT NOT NULL, user_retrait_id INT NOT NULL, code VARCHAR(255) NOT NULL, montant INT NOT NULL, part_etat INT NOT NULL, part_entreprise INT NOT NULL, part_agent_retrait INT NOT NULL, part_agent_depot INT NOT NULL, archivage TINYINT(1) NOT NULL, date_depot DATE NOT NULL, date_retrait DATE DEFAULT NULL, UNIQUE INDEX UNIQ_6BBEF3B9AB014612 (clients_id), INDEX IDX_6BBEF3B9DCED588B (comptes_id), INDEX IDX_6BBEF3B9659D30DE (user_depot_id), INDEX IDX_6BBEF3B9D99F8396 (user_retrait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bloc_transaction ADD CONSTRAINT FK_6BBEF3B9AB014612 FOREIGN KEY (clients_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE bloc_transaction ADD CONSTRAINT FK_6BBEF3B9DCED588B FOREIGN KEY (comptes_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE bloc_transaction ADD CONSTRAINT FK_6BBEF3B9659D30DE FOREIGN KEY (user_depot_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE bloc_transaction ADD CONSTRAINT FK_6BBEF3B9D99F8396 FOREIGN KEY (user_retrait_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bloc_transaction');
    }
}
