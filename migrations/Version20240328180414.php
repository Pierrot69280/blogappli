<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328180414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE like_id_seq CASCADE');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT fk_ac6340b3f675f31b');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT fk_ac6340b37294869c');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT fk_ac6340b3f8697d13');
        $this->addSql('DROP TABLE "like"');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE like_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "like" (id INT NOT NULL, author_id INT DEFAULT NULL, article_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_ac6340b3f8697d13 ON "like" (comment_id)');
        $this->addSql('CREATE INDEX idx_ac6340b37294869c ON "like" (article_id)');
        $this->addSql('CREATE INDEX idx_ac6340b3f675f31b ON "like" (author_id)');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT fk_ac6340b3f675f31b FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT fk_ac6340b37294869c FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT fk_ac6340b3f8697d13 FOREIGN KEY (comment_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
