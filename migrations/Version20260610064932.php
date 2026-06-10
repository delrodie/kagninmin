<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260610064932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE galerie_video (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, date_action DATE DEFAULT NULL, cover VARCHAR(255) DEFAULT NULL, media VARCHAR(255) DEFAULT NULL, is_actif TINYINT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, domaine_id INT DEFAULT NULL, INDEX IDX_2D41D5BA4272FC9F (domaine_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE galerie_video ADD CONSTRAINT FK_2D41D5BA4272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galerie_video DROP FOREIGN KEY FK_2D41D5BA4272FC9F');
        $this->addSql('DROP TABLE galerie_video');
    }
}
