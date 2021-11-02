<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211102091027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie ADD illustration LONGTEXT DEFAULT NULL, ADD average_note INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26F7E3C61F9');
        $this->addSql('ALTER TABLE movie DROP illustration, DROP average_note');
        $this->addSql('DROP INDEX idx_1d5ef26f7e3c61f9 ON movie');
        $this->addSql('CREATE INDEX IDX_1D5EF26FA76ED395 ON movie (owner_id)');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE thematic CHANGE owner_id owner_id INT DEFAULT NULL');
    }
}
