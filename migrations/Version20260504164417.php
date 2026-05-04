<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260504164417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, contenu LONGTEXT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, media VARCHAR(255) DEFAULT NULL, is_atif TINYINT DEFAULT NULL, date_action DATE DEFAULT NULL, published_at DATETIME DEFAULT NULL, domaine_id INT DEFAULT NULL, INDEX IDX_549281974272FC9F (domaine_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE domaine (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, contenu LONGTEXT DEFAULT NULL, media VARCHAR(255) DEFAULT NULL, is_actif TINYINT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, media VARCHAR(255) DEFAULT NULL, legende VARCHAR(255) DEFAULT NULL, uploaded_at DATETIME DEFAULT NULL, actualite_id INT DEFAULT NULL, INDEX IDX_14B78418A2843073 (actualite_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_549281974272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418A2843073 FOREIGN KEY (actualite_id) REFERENCES actualite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_549281974272FC9F');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418A2843073');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE domaine');
        $this->addSql('DROP TABLE photo');
    }
}
