<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307182449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE channel (id INT AUTO_INCREMENT NOT NULL, settings_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A2F98E4759949888 (settings_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE channel_follower (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, channel_id INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_CE667AEF9B6B5FBA (account_id), UNIQUE INDEX UNIQ_CE667AEF72F5A1AA (channel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE management (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, chat_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, is_deleted TINYINT(1) NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_B6BD307FA76ED395 (user_id), INDEX IDX_B6BD307F1A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stream (id INT AUTO_INCREMENT NOT NULL, settings_id INT DEFAULT NULL, chat_id INT DEFAULT NULL, channel_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, starting_at DATETIME NOT NULL, ending_at DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_F0E9BE1C59949888 (settings_id), UNIQUE INDEX UNIQ_F0E9BE1C1A9A7125 (chat_id), INDEX IDX_F0E9BE1C72F5A1AA (channel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stream_manager (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, rules JSON NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_AC4DCE4A9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stream_viewer (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, stream_id INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D9737C609B6B5FBA (account_id), UNIQUE INDEX UNIQ_D9737C60D0ED463E (stream_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E4759949888 FOREIGN KEY (settings_id) REFERENCES settings (id)');
        $this->addSql('ALTER TABLE channel_follower ADD CONSTRAINT FK_CE667AEF9B6B5FBA FOREIGN KEY (account_id) REFERENCES stream (id)');
        $this->addSql('ALTER TABLE channel_follower ADD CONSTRAINT FK_CE667AEF72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE stream ADD CONSTRAINT FK_F0E9BE1C59949888 FOREIGN KEY (settings_id) REFERENCES settings (id)');
        $this->addSql('ALTER TABLE stream ADD CONSTRAINT FK_F0E9BE1C1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE stream ADD CONSTRAINT FK_F0E9BE1C72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id)');
        $this->addSql('ALTER TABLE stream_manager ADD CONSTRAINT FK_AC4DCE4A9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE stream_viewer ADD CONSTRAINT FK_D9737C609B6B5FBA FOREIGN KEY (account_id) REFERENCES stream (id)');
        $this->addSql('ALTER TABLE stream_viewer ADD CONSTRAINT FK_D9737C60D0ED463E FOREIGN KEY (stream_id) REFERENCES stream (id)');
        $this->addSql('ALTER TABLE account DROP is_deleted, CHANGE deleted_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE account_information DROP is_deleted, CHANGE deleted_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE settings DROP is_deleted, CHANGE deleted_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP is_deleted, CHANGE deleted_at created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE channel_follower DROP FOREIGN KEY FK_CE667AEF72F5A1AA');
        $this->addSql('ALTER TABLE stream DROP FOREIGN KEY FK_F0E9BE1C72F5A1AA');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1A9A7125');
        $this->addSql('ALTER TABLE stream DROP FOREIGN KEY FK_F0E9BE1C1A9A7125');
        $this->addSql('ALTER TABLE channel_follower DROP FOREIGN KEY FK_CE667AEF9B6B5FBA');
        $this->addSql('ALTER TABLE stream_viewer DROP FOREIGN KEY FK_D9737C609B6B5FBA');
        $this->addSql('ALTER TABLE stream_viewer DROP FOREIGN KEY FK_D9737C60D0ED463E');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE channel_follower');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE management');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE stream');
        $this->addSql('DROP TABLE stream_manager');
        $this->addSql('DROP TABLE stream_viewer');
        $this->addSql('ALTER TABLE account ADD is_deleted TINYINT(1) NOT NULL, CHANGE created_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE account_information ADD is_deleted TINYINT(1) NOT NULL, CHANGE created_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE settings ADD is_deleted TINYINT(1) NOT NULL, CHANGE created_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD is_deleted TINYINT(1) NOT NULL, CHANGE created_at deleted_at DATETIME DEFAULT NULL');
    }
}
