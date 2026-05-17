<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260517170141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_view (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, referrer VARCHAR(255) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, country_code VARCHAR(2) DEFAULT NULL, country_name VARCHAR(100) DEFAULT NULL, user_agent VARCHAR(255) DEFAULT NULL, visitor_hash VARCHAR(32) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE page_view');
    }
}
