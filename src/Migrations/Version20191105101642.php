<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191105101642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE point_of_interest_types DROP FOREIGN KEY FK_9F31D5F01FE9DE17');
        $this->addSql('DROP INDEX IDX_9F31D5F01FE9DE17 ON point_of_interest_types');
        $this->addSql('ALTER TABLE point_of_interest_types CHANGE point_of_interest_id point_of_interests_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE point_of_interest_types ADD CONSTRAINT FK_9F31D5F064BDD13C FOREIGN KEY (point_of_interests_id) REFERENCES point_of_interest (id)');
        $this->addSql('CREATE INDEX IDX_9F31D5F064BDD13C ON point_of_interest_types (point_of_interests_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE point_of_interest_types DROP FOREIGN KEY FK_9F31D5F064BDD13C');
        $this->addSql('DROP INDEX IDX_9F31D5F064BDD13C ON point_of_interest_types');
        $this->addSql('ALTER TABLE point_of_interest_types CHANGE point_of_interests_id point_of_interest_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE point_of_interest_types ADD CONSTRAINT FK_9F31D5F01FE9DE17 FOREIGN KEY (point_of_interest_id) REFERENCES point_of_interest (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9F31D5F01FE9DE17 ON point_of_interest_types (point_of_interest_id)');
    }
}
