<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325181708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526c2f23775f');
        $this->addSql('DROP INDEX idx_9474526c2f23775f');
        $this->addSql('ALTER TABLE comment DROP likes_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment ADD likes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526c2f23775f FOREIGN KEY (likes_id) REFERENCES "like" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9474526c2f23775f ON comment (likes_id)');
    }
}
