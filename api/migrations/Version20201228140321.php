<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201228140321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE temps CHANGE palier15 palier15 INT DEFAULT NULL, CHANGE palier12 palier12 INT DEFAULT NULL, CHANGE palier9 palier9 INT DEFAULT NULL, CHANGE palier6 palier6 INT DEFAULT NULL, CHANGE palier3 palier3 INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE temps CHANGE palier15 palier15 INT DEFAULT NULL, CHANGE palier12 palier12 INT DEFAULT NULL, CHANGE palier9 palier9 INT DEFAULT NULL, CHANGE palier6 palier6 INT DEFAULT NULL, CHANGE palier3 palier3 INT DEFAULT NULL');
    }
}
