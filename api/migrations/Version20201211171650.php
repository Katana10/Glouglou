<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201211171650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profondeur ADD table_associee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profondeur ADD CONSTRAINT FK_E3804DEA459793F1 FOREIGN KEY (table_associee_id) REFERENCES table_plongee (id)');
        $this->addSql('CREATE INDEX IDX_E3804DEA459793F1 ON profondeur (table_associee_id)');
        $this->addSql('ALTER TABLE temps ADD est_a_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE temps ADD CONSTRAINT FK_60B4B72010C32089 FOREIGN KEY (est_a_id) REFERENCES profondeur (id)');
        $this->addSql('CREATE INDEX IDX_60B4B72010C32089 ON temps (est_a_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profondeur DROP FOREIGN KEY FK_E3804DEA459793F1');
        $this->addSql('DROP INDEX IDX_E3804DEA459793F1 ON profondeur');
        $this->addSql('ALTER TABLE profondeur DROP table_associee_id');
        $this->addSql('ALTER TABLE temps DROP FOREIGN KEY FK_60B4B72010C32089');
        $this->addSql('DROP INDEX IDX_60B4B72010C32089 ON temps');
        $this->addSql('ALTER TABLE temps DROP est_a_id');
    }
}
