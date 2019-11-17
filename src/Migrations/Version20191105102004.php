<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191105102004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE point_of_interest ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE point_of_interest ADD CONSTRAINT FK_E67AD359C54C8C93 FOREIGN KEY (type_id) REFERENCES point_of_interest_types (id)');
        $this->addSql('CREATE INDEX IDX_E67AD359C54C8C93 ON point_of_interest (type_id)');
        $this->addSql('ALTER TABLE point_of_interest_types DROP FOREIGN KEY FK_9F31D5F064BDD13C');
        $this->addSql('DROP INDEX IDX_9F31D5F064BDD13C ON point_of_interest_types');
        $this->addSql('ALTER TABLE point_of_interest_types DROP point_of_interests_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE point_of_interest DROP FOREIGN KEY FK_E67AD359C54C8C93');
        $this->addSql('DROP INDEX IDX_E67AD359C54C8C93 ON point_of_interest');
        $this->addSql('ALTER TABLE point_of_interest DROP type_id');
        $this->addSql('ALTER TABLE point_of_interest_types ADD point_of_interests_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE point_of_interest_types ADD CONSTRAINT FK_9F31D5F064BDD13C FOREIGN KEY (point_of_interests_id) REFERENCES point_of_interest (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9F31D5F064BDD13C ON point_of_interest_types (point_of_interests_id)');
    }
}
