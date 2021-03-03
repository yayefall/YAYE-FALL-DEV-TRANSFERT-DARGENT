<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226122908 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions ADD comptes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CDCED588B FOREIGN KEY (comptes_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CDCED588B ON transactions (comptes_id)');
        $this->addSql('ALTER TABLE user CHANGE photo photo LONGBLOB DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CDCED588B');
        $this->addSql('DROP INDEX IDX_EAA81A4CDCED588B ON transactions');
        $this->addSql('ALTER TABLE transactions DROP comptes_id');
        $this->addSql('ALTER TABLE `user` CHANGE photo photo LONGBLOB NOT NULL');
    }
}
