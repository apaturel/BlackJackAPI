<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221003121719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carte_joueur (id INT AUTO_INCREMENT NOT NULL, carte1 VARCHAR(255) NOT NULL, carte2 VARCHAR(255) NOT NULL, carte3 VARCHAR(255) DEFAULT NULL, carte4 VARCHAR(255) DEFAULT NULL, carte5 VARCHAR(255) DEFAULT NULL, carte6 VARCHAR(255) DEFAULT NULL, carte7 VARCHAR(255) DEFAULT NULL, carte8 VARCHAR(255) DEFAULT NULL, carte9 VARCHAR(255) DEFAULT NULL, carte10 VARCHAR(255) DEFAULT NULL, carte11 VARCHAR(255) DEFAULT NULL, carte12 VARCHAR(255) DEFAULT NULL, carte13 VARCHAR(255) DEFAULT NULL, carte14 VARCHAR(255) DEFAULT NULL, carte15 VARCHAR(255) DEFAULT NULL, carte16 VARCHAR(255) DEFAULT NULL, carte17 VARCHAR(255) DEFAULT NULL, carte18 VARCHAR(255) DEFAULT NULL, carte19 VARCHAR(255) DEFAULT NULL, carte20 VARCHAR(255) DEFAULT NULL, carte21 VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE carte_joueur');
    }
}
