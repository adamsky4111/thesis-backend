<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230130256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_channel_subscribe DROP FOREIGN KEY FK_461C04709B6B5FBA');
        $this->addSql('ALTER TABLE account_channel_subscribe ADD CONSTRAINT FK_461C04709B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_channel_subscribe DROP FOREIGN KEY FK_461C04709B6B5FBA');
        $this->addSql('ALTER TABLE account_channel_subscribe ADD CONSTRAINT FK_461C04709B6B5FBA FOREIGN KEY (account_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
