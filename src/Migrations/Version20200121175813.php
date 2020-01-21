<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200121175813 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE telegram_chat_project');
        $this->addSql('DROP TABLE telegram_settings');
        $this->addSql('ALTER TABLE monitoring_task ADD yes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE monitoring_task ADD CONSTRAINT FK_8AA3F5962CB716C7 FOREIGN KEY (yes_id) REFERENCES telegram_chat (id)');
        $this->addSql('CREATE INDEX IDX_8AA3F5962CB716C7 ON monitoring_task (yes_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE telegram_chat_project (telegram_chat_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_A0B5CF1166D1F9C (project_id), INDEX IDX_A0B5CF141DC10D3 (telegram_chat_id), PRIMARY KEY(telegram_chat_id, project_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE telegram_settings (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE telegram_chat_project ADD CONSTRAINT FK_A0B5CF1166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE telegram_chat_project ADD CONSTRAINT FK_A0B5CF141DC10D3 FOREIGN KEY (telegram_chat_id) REFERENCES telegram_chat (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE monitoring_task DROP FOREIGN KEY FK_8AA3F5962CB716C7');
        $this->addSql('DROP INDEX IDX_8AA3F5962CB716C7 ON monitoring_task');
        $this->addSql('ALTER TABLE monitoring_task DROP yes_id');
    }
}
