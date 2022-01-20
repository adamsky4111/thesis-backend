<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211231094738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stream_categories (stream_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_495786CD0ED463E (stream_id), INDEX IDX_495786C12469DE2 (category_id), PRIMARY KEY(stream_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events_tags (stream_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_3EC905CD0ED463E (stream_id), INDEX IDX_3EC905CBAD26311 (tag_id), PRIMARY KEY(stream_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stream_category (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, name VARCHAR(120) NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_22AED38CA977936C (tree_root), INDEX IDX_22AED38C727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stream_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stream_categories ADD CONSTRAINT FK_495786CD0ED463E FOREIGN KEY (stream_id) REFERENCES stream (id)');
        $this->addSql('ALTER TABLE stream_categories ADD CONSTRAINT FK_495786C12469DE2 FOREIGN KEY (category_id) REFERENCES stream_category (id)');
        $this->addSql('ALTER TABLE events_tags ADD CONSTRAINT FK_3EC905CD0ED463E FOREIGN KEY (stream_id) REFERENCES stream (id)');
        $this->addSql('ALTER TABLE events_tags ADD CONSTRAINT FK_3EC905CBAD26311 FOREIGN KEY (tag_id) REFERENCES stream_tag (id)');
        $this->addSql('ALTER TABLE stream_category ADD CONSTRAINT FK_22AED38CA977936C FOREIGN KEY (tree_root) REFERENCES stream_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stream_category ADD CONSTRAINT FK_22AED38C727ACA70 FOREIGN KEY (parent_id) REFERENCES stream_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stream ADD main_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stream ADD CONSTRAINT FK_F0E9BE1CC6C55574 FOREIGN KEY (main_category_id) REFERENCES stream_category (id)');
        $this->addSql('CREATE INDEX IDX_F0E9BE1CC6C55574 ON stream (main_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stream DROP FOREIGN KEY FK_F0E9BE1CC6C55574');
        $this->addSql('ALTER TABLE stream_categories DROP FOREIGN KEY FK_495786C12469DE2');
        $this->addSql('ALTER TABLE stream_category DROP FOREIGN KEY FK_22AED38CA977936C');
        $this->addSql('ALTER TABLE stream_category DROP FOREIGN KEY FK_22AED38C727ACA70');
        $this->addSql('ALTER TABLE events_tags DROP FOREIGN KEY FK_3EC905CBAD26311');
        $this->addSql('DROP TABLE stream_categories');
        $this->addSql('DROP TABLE events_tags');
        $this->addSql('DROP TABLE stream_category');
        $this->addSql('DROP TABLE stream_tag');
        $this->addSql('DROP INDEX IDX_F0E9BE1CC6C55574 ON stream');
        $this->addSql('ALTER TABLE stream DROP main_category_id');
    }
}
