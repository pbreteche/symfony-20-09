<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * @TODO split into two migrations :
 *   1: add nullable column and new table
 *   2: insert data and make column not nullable
 */
final class Version20200923071037 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, nickname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD written_by_id INT');
        $this->connection->commit();
        $authors = $this->connection->fetchAssoc('SELECT DISTINCT author FROM post');
        foreach ($authors as $author) {
            $this->connection->insert('author', ['nickname' => $author]);

            $authorId = $this->connection->lastInsertId();

            $postIds = $this->connection->fetchAll('SELECT id FROM post WHERE author = :author', [
                'author' => $author,
            ]);

            $stringPostIds = array_column($postIds, 'id');

            foreach ($stringPostIds as $id) {
                $this->connection->update('post', ['writtenBy' => $authorId], $id);
            }
        }
        $this->addSql('ALTER TABLE post CHANGE written_by_id written_by_id INT NOT NULL, DROP author');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DAB69C8EF FOREIGN KEY (written_by_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DAB69C8EF ON post (written_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DAB69C8EF');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP INDEX IDX_5A8A6C8DAB69C8EF ON post');
        $this->addSql('ALTER TABLE post ADD author VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP written_by_id');
    }
}
