<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229135336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disc DROP FOREIGN KEY FK_2AF55301E5D0459');
        $this->addSql('DROP INDEX IDX_2AF55301E5D0459 ON disc');
        $this->addSql('ALTER TABLE disc CHANGE test_id label_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE disc ADD CONSTRAINT FK_2AF553033B92F39 FOREIGN KEY (label_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_2AF553033B92F39 ON disc (label_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disc DROP FOREIGN KEY FK_2AF553033B92F39');
        $this->addSql('DROP INDEX IDX_2AF553033B92F39 ON disc');
        $this->addSql('ALTER TABLE disc CHANGE label_id test_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE disc ADD CONSTRAINT FK_2AF55301E5D0459 FOREIGN KEY (test_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_2AF55301E5D0459 ON disc (test_id)');
    }
}
