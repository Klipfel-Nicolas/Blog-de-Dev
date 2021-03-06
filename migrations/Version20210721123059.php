<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721123059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_review ADD article_id INT NOT NULL, ADD author VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE article_review ADD CONSTRAINT FK_138416467294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_138416467294869C ON article_review (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_review DROP FOREIGN KEY FK_138416467294869C');
        $this->addSql('DROP INDEX IDX_138416467294869C ON article_review');
        $this->addSql('ALTER TABLE article_review DROP article_id, DROP author');
    }
}
