<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220117222320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stream_images (stream_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_3A306E5FD0ED463E (stream_id), INDEX IDX_3A306E5F3DA5256D (image_id), PRIMARY KEY(stream_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stream_tags (stream_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_D8ABAD85D0ED463E (stream_id), INDEX IDX_D8ABAD85BAD26311 (tag_id), PRIMARY KEY(stream_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stream_images ADD CONSTRAINT FK_3A306E5FD0ED463E FOREIGN KEY (stream_id) REFERENCES stream (id)');
        $this->addSql('ALTER TABLE stream_images ADD CONSTRAINT FK_3A306E5F3DA5256D FOREIGN KEY (image_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE stream_tags ADD CONSTRAINT FK_D8ABAD85D0ED463E FOREIGN KEY (stream_id) REFERENCES stream (id)');
        $this->addSql('ALTER TABLE stream_tags ADD CONSTRAINT FK_D8ABAD85BAD26311 FOREIGN KEY (tag_id) REFERENCES stream_tag (id)');
        $this->addSql('DROP TABLE events_tags');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE events_tags (stream_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_3EC905CBAD26311 (tag_id), INDEX IDX_3EC905CD0ED463E (stream_id), PRIMARY KEY(stream_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE events_tags ADD CONSTRAINT FK_3EC905CBAD26311 FOREIGN KEY (tag_id) REFERENCES stream_tag (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE events_tags ADD CONSTRAINT FK_3EC905CD0ED463E FOREIGN KEY (stream_id) REFERENCES stream (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE stream_images');
        $this->addSql('DROP TABLE stream_tags');
    }
}
