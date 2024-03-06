<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229135432 extends AbstractMigration
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
        $this->addSql('ALTER TABLE disc DROP test_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disc ADD test_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE disc ADD CONSTRAINT FK_2AF55301E5D0459 FOREIGN KEY (test_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_2AF55301E5D0459 ON disc (test_id)');
    }
}
