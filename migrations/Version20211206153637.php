<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211206153637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stream_schedule (id INT AUTO_INCREMENT NOT NULL, stream_id INT DEFAULT NULL, executed DATETIME NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_7EDADBB6D0ED463E (stream_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stream_schedule ADD CONSTRAINT FK_7EDADBB6D0ED463E FOREIGN KEY (stream_id) REFERENCES stream (id)');
        $this->addSql('ALTER TABLE channel CHANGE `default` is_default TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE settings DROP FOREIGN KEY FK_E545A0C59B6B5FBA');
        $this->addSql('ALTER TABLE settings ADD CONSTRAINT FK_E545A0C59B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stream_schedule');
        $this->addSql('ALTER TABLE channel CHANGE is_default `default` TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE settings DROP FOREIGN KEY FK_E545A0C59B6B5FBA');
        $this->addSql('ALTER TABLE settings ADD CONSTRAINT FK_E545A0C59B6B5FBA FOREIGN KEY (account_id) REFERENCES settings (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
