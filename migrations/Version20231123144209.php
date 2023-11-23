<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123144209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taxonomy_term ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_term ADD CONSTRAINT FK_C7ED653A4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_C7ED653A4584665A ON taxonomy_term (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taxonomy_term DROP FOREIGN KEY FK_C7ED653A4584665A');
        $this->addSql('DROP INDEX IDX_C7ED653A4584665A ON taxonomy_term');
        $this->addSql('ALTER TABLE taxonomy_term DROP product_id');
    }
}
