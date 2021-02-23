<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210222173907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD profil_id INT DEFAULT NULL, ADD nom VARCHAR(100) NOT NULL, ADD prenom VARCHAR(100) NOT NULL, ADD email VARCHAR(100) NOT NULL, ADD telephone VARCHAR(100) NOT NULL, ADD photo LONGBLOB NOT NULL, ADD archivage TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profils (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649275ED078 ON user (profil_id)');
        $this->addSql('ALTER TABLE user_agence_partenaire ADD compte_transactions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_agence_partenaire ADD CONSTRAINT FK_E0FCD87BE2D292F FOREIGN KEY (compte_transactions_id) REFERENCES compte_transaction (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E0FCD87BE2D292F ON user_agence_partenaire (compte_transactions_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('DROP INDEX IDX_8D93D649275ED078 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP profil_id, DROP nom, DROP prenom, DROP email, DROP telephone, DROP photo, DROP archivage');
        $this->addSql('ALTER TABLE user_agence_partenaire DROP FOREIGN KEY FK_E0FCD87BE2D292F');
        $this->addSql('DROP INDEX UNIQ_E0FCD87BE2D292F ON user_agence_partenaire');
        $this->addSql('ALTER TABLE user_agence_partenaire DROP compte_transactions_id');
    }
}
