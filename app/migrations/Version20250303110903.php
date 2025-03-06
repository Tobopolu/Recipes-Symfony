<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250303110903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe CHANGE title title VARCHAR(50) NOT NULL, CHANGE image image LONGTEXT DEFAULT NULL, CHANGE instructions instructions LONGTEXT NOT NULL, CHANGE prep_time prep_time INT NOT NULL, CHANGE cook_time cook_time INT NOT NULL, CHANGE difficulty difficulty VARCHAR(10) DEFAULT \'Facile\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe CHANGE title title TEXT NOT NULL, CHANGE image image TEXT DEFAULT NULL, CHANGE instructions instructions TEXT NOT NULL, CHANGE prep_time prep_time INT DEFAULT 0 NOT NULL, CHANGE cook_time cook_time INT DEFAULT 0 NOT NULL, CHANGE difficulty difficulty ENUM(\'Facile\', \'Moyenne\', \'Difficile\') DEFAULT \'Facile\' NOT NULL');
    }
}
