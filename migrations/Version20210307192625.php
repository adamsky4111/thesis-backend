<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307192625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE channel ADD account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E479B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_A2F98E479B6B5FBA ON channel (account_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE channel DROP FOREIGN KEY FK_A2F98E479B6B5FBA');
        $this->addSql('DROP INDEX IDX_A2F98E479B6B5FBA ON channel');
        $this->addSql('ALTER TABLE channel DROP account_id');
    }
}
