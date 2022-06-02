<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220331145539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artistes CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE image image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE oeuvres ADD artiste_id INT DEFAULT NULL, DROP artiste');
        $this->addSql('ALTER TABLE oeuvres ADD CONSTRAINT FK_413EEE3E21D25844 FOREIGN KEY (artiste_id) REFERENCES artistes (id)');
        $this->addSql('CREATE INDEX IDX_413EEE3E21D25844 ON oeuvres (artiste_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvres DROP FOREIGN KEY FK_413EEE3E21D25844');
        $this->addSql('DROP INDEX IDX_413EEE3E21D25844 ON oeuvres');
        $this->addSql('ALTER TABLE oeuvres ADD artiste VARCHAR(255) NOT NULL, DROP artiste_id');
    }
}
