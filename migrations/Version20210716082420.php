<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716082420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehicule_conducteur (vehicule_id INT NOT NULL, conducteur_id INT NOT NULL, INDEX IDX_7F78EBEC4A4A3511 (vehicule_id), INDEX IDX_7F78EBECF16F4AC6 (conducteur_id), PRIMARY KEY(vehicule_id, conducteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicule_conducteur ADD CONSTRAINT FK_7F78EBEC4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicule_conducteur ADD CONSTRAINT FK_7F78EBECF16F4AC6 FOREIGN KEY (conducteur_id) REFERENCES conducteur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vehicule_conducteur');
    }
}
