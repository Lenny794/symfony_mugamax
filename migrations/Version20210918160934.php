<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210918160934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE setting_user_preference ADD pseudo VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD birthdate DATE NOT NULL, ADD country VARCHAR(255) NOT NULL, ADD playstation VARCHAR(255) NOT NULL, ADD xbox VARCHAR(255) NOT NULL, ADD nintendo VARCHAR(255) NOT NULL, ADD steam VARCHAR(255) NOT NULL, ADD twitch VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE setting_user_preference DROP pseudo, DROP firstname, DROP lastname, DROP birthdate, DROP country, DROP playstation, DROP xbox, DROP nintendo, DROP steam, DROP twitch');
    }
}
