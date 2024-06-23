<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116145627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE citation CHANGE idauteur idauteur INT NOT NULL, CHANGE text text LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE citation RENAME INDEX fk_citation_auteur TO IDX_FABD9C7E61E71CEC');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE citation CHANGE idauteur idauteur INT DEFAULT NULL, CHANGE text text VARCHAR(500) NOT NULL');
        $this->addSql('ALTER TABLE citation RENAME INDEX idx_fabd9c7e61e71cec TO fk_citation_auteur');
    }
}
