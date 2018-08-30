<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180824090738 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mp3file (id INT AUTO_INCREMENT NOT NULL, mp3metadata_id INT NOT NULL, fullpath VARCHAR(200) NOT NULL, basename VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_3775D4C084C64670 (mp3metadata_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mp3metadata (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) DEFAULT NULL, artist VARCHAR(50) DEFAULT NULL, album VARCHAR(50) DEFAULT NULL, duration INT DEFAULT NULL, year DATETIME DEFAULT NULL, genre VARCHAR(30) DEFAULT NULL, comment VARCHAR(50) DEFAULT NULL, contributor VARCHAR(30) DEFAULT NULL, bitrate INT DEFAULT NULL, track INT DEFAULT NULL, popularity_meter VARCHAR(30) DEFAULT NULL, unique_file_identifier VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mp3metadata_blob (id INT AUTO_INCREMENT NOT NULL, concat_metadata LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mp3file ADD CONSTRAINT FK_3775D4C084C64670 FOREIGN KEY (mp3metadata_id) REFERENCES mp3metadata (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mp3file DROP FOREIGN KEY FK_3775D4C084C64670');
        $this->addSql('DROP TABLE mp3file');
        $this->addSql('DROP TABLE mp3metadata');
        $this->addSql('DROP TABLE mp3metadata_blob');
    }
}
