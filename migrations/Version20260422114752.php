<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260422114752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE breed (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET UTF8MB4');
        $this->addSql('CREATE TABLE cat (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, birth_dated DATE NOT NULL, breed_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, INDEX IDX_9E5E43A8A8B4A30F (breed_id), INDEX IDX_9E5E43A87E3C61F9 (owner_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET UTF8MB4');
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET UTF8MB4');
        $this->addSql('ALTER TABLE cat ADD CONSTRAINT FK_9E5E43A8A8B4A30F FOREIGN KEY (breed_id) REFERENCES breed (id)');
        $this->addSql('ALTER TABLE cat ADD CONSTRAINT FK_9E5E43A87E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cat DROP FOREIGN KEY FK_9E5E43A8A8B4A30F');
        $this->addSql('ALTER TABLE cat DROP FOREIGN KEY FK_9E5E43A87E3C61F9');
        $this->addSql('DROP TABLE breed');
        $this->addSql('DROP TABLE cat');
        $this->addSql('DROP TABLE owner');
    }
}
