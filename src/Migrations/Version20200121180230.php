<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200121180230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE monitoring_task DROP FOREIGN KEY FK_8AA3F5962CB716C7');
        $this->addSql('DROP INDEX IDX_8AA3F5962CB716C7 ON monitoring_task');
        $this->addSql('ALTER TABLE monitoring_task CHANGE yes_id telegram_chat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE monitoring_task ADD CONSTRAINT FK_8AA3F59641DC10D3 FOREIGN KEY (telegram_chat_id) REFERENCES telegram_chat (id)');
        $this->addSql('CREATE INDEX IDX_8AA3F59641DC10D3 ON monitoring_task (telegram_chat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE monitoring_task DROP FOREIGN KEY FK_8AA3F59641DC10D3');
        $this->addSql('DROP INDEX IDX_8AA3F59641DC10D3 ON monitoring_task');
        $this->addSql('ALTER TABLE monitoring_task CHANGE telegram_chat_id yes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE monitoring_task ADD CONSTRAINT FK_8AA3F5962CB716C7 FOREIGN KEY (yes_id) REFERENCES telegram_chat (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8AA3F5962CB716C7 ON monitoring_task (yes_id)');
    }
}
