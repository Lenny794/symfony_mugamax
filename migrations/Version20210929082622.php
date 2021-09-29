<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210929082622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actuality_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, actuality_news_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_3CD18099A76ED395 (user_id), INDEX IDX_3CD180991D018B55 (actuality_news_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actuality_news (id INT AUTO_INCREMENT NOT NULL, category_news_id INT DEFAULT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_2261F53B727C19DE (category_news_id), INDEX IDX_2261F53BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_news (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_topic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_path_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, category_topic_id INT DEFAULT NULL, user_id INT DEFAULT NULL, subjet VARCHAR(255) NOT NULL, INDEX IDX_9D40DE1BA82FA446 (category_topic_id), INDEX IDX_9D40DE1BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, topic_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_1CDF0FB9A76ED395 (user_id), INDEX IDX_1CDF0FB91F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, country VARCHAR(255) NOT NULL, avatar_user VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64986CC499D (pseudo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actuality_comment ADD CONSTRAINT FK_3CD18099A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE actuality_comment ADD CONSTRAINT FK_3CD180991D018B55 FOREIGN KEY (actuality_news_id) REFERENCES actuality_news (id)');
        $this->addSql('ALTER TABLE actuality_news ADD CONSTRAINT FK_2261F53B727C19DE FOREIGN KEY (category_news_id) REFERENCES category_news (id)');
        $this->addSql('ALTER TABLE actuality_news ADD CONSTRAINT FK_2261F53BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BA82FA446 FOREIGN KEY (category_topic_id) REFERENCES category_topic (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE topic_comment ADD CONSTRAINT FK_1CDF0FB9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE topic_comment ADD CONSTRAINT FK_1CDF0FB91F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actuality_comment DROP FOREIGN KEY FK_3CD180991D018B55');
        $this->addSql('ALTER TABLE actuality_news DROP FOREIGN KEY FK_2261F53B727C19DE');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BA82FA446');
        $this->addSql('ALTER TABLE topic_comment DROP FOREIGN KEY FK_1CDF0FB91F55203D');
        $this->addSql('ALTER TABLE actuality_comment DROP FOREIGN KEY FK_3CD18099A76ED395');
        $this->addSql('ALTER TABLE actuality_news DROP FOREIGN KEY FK_2261F53BA76ED395');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BA76ED395');
        $this->addSql('ALTER TABLE topic_comment DROP FOREIGN KEY FK_1CDF0FB9A76ED395');
        $this->addSql('DROP TABLE actuality_comment');
        $this->addSql('DROP TABLE actuality_news');
        $this->addSql('DROP TABLE category_news');
        $this->addSql('DROP TABLE category_topic');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE topic_comment');
        $this->addSql('DROP TABLE user');
    }
}
