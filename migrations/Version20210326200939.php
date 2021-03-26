<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326200939 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account ADD actual_stream_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4EB0B20DD FOREIGN KEY (actual_stream_id) REFERENCES stream (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4EB0B20DD ON account (actual_stream_id)');
        $this->addSql('ALTER TABLE channel ADD `default` TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE stream ADD is_active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A4EB0B20DD');
        $this->addSql('DROP INDEX UNIQ_7D3656A4EB0B20DD ON account');
        $this->addSql('ALTER TABLE account DROP actual_stream_id');
        $this->addSql('ALTER TABLE channel DROP `default`');
        $this->addSql('ALTER TABLE stream DROP is_active');
    }
}
