<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419184913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE account_settings');
        $this->addSql('ALTER TABLE settings ADD account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE settings ADD CONSTRAINT FK_E545A0C59B6B5FBA FOREIGN KEY (account_id) REFERENCES settings (id)');
        $this->addSql('CREATE INDEX IDX_E545A0C59B6B5FBA ON settings (account_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account_settings (account_id INT NOT NULL, setting_id INT NOT NULL, INDEX IDX_9D8B42739B6B5FBA (account_id), INDEX IDX_9D8B4273EE35BD72 (setting_id), PRIMARY KEY(account_id, setting_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE account_settings ADD CONSTRAINT FK_9D8B42739B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE account_settings ADD CONSTRAINT FK_9D8B4273EE35BD72 FOREIGN KEY (setting_id) REFERENCES settings (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE settings DROP FOREIGN KEY FK_E545A0C59B6B5FBA');
        $this->addSql('DROP INDEX IDX_E545A0C59B6B5FBA ON settings');
        $this->addSql('ALTER TABLE settings DROP account_id');
    }
}
