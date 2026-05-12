<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260512160857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coordonnee (id INT AUTO_INCREMENT NOT NULL, siege VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, horaire VARCHAR(255) DEFAULT NULL, telephone VARCHAR(32) DEFAULT NULL, phone1 VARCHAR(32) DEFAULT NULL, phone2 VARCHAR(32) DEFAULT NULL, phone3 VARCHAR(32) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE destinataire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, contenu LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, is_read TINYINT DEFAULT NULL, readed_at DATETIME DEFAULT NULL, readed_by VARCHAR(255) DEFAULT NULL, sended_at DATETIME DEFAULT NULL, objet_id INT DEFAULT NULL, INDEX IDX_B6BD307FF520CF5A (objet_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, is_actif TINYINT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF520CF5A');
        $this->addSql('DROP TABLE coordonnee');
        $this->addSql('DROP TABLE destinataire');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE objet');
    }
}
