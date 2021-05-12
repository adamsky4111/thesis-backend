<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411221320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, filename VARCHAR(120) NOT NULL, original_filename VARCHAR(120) NOT NULL, size VARCHAR(120) NOT NULL, type VARCHAR(120) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_6A2CA10C7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES settings (id)');
        $this->addSql('ALTER TABLE account ADD avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A486383B10 FOREIGN KEY (avatar_id) REFERENCES media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A486383B10 ON account (avatar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A486383B10');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP INDEX UNIQ_7D3656A486383B10 ON account');
        $this->addSql('ALTER TABLE account DROP avatar_id');
    }
}
