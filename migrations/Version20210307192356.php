<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307192356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stream_management (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE management');
        $this->addSql('ALTER TABLE stream_manager ADD management_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stream_manager ADD CONSTRAINT FK_AC4DCE4A80D51D0E FOREIGN KEY (management_id) REFERENCES stream_management (id)');
        $this->addSql('CREATE INDEX IDX_AC4DCE4A80D51D0E ON stream_manager (management_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stream_manager DROP FOREIGN KEY FK_AC4DCE4A80D51D0E');
        $this->addSql('CREATE TABLE management (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE stream_management');
        $this->addSql('DROP INDEX IDX_AC4DCE4A80D51D0E ON stream_manager');
        $this->addSql('ALTER TABLE stream_manager DROP management_id');
    }
}
