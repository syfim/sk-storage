<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200121175321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE telegram_settings (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telegram_chat (id INT AUTO_INCREMENT NOT NULL, bot_id VARCHAR(255) NOT NULL, bot_token VARCHAR(255) NOT NULL, chat_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telegram_chat_project (telegram_chat_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_A0B5CF141DC10D3 (telegram_chat_id), INDEX IDX_A0B5CF1166D1F9C (project_id), PRIMARY KEY(telegram_chat_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE telegram_chat_project ADD CONSTRAINT FK_A0B5CF141DC10D3 FOREIGN KEY (telegram_chat_id) REFERENCES telegram_chat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE telegram_chat_project ADD CONSTRAINT FK_A0B5CF1166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE telegram_chat_project DROP FOREIGN KEY FK_A0B5CF141DC10D3');
        $this->addSql('DROP TABLE telegram_settings');
        $this->addSql('DROP TABLE telegram_chat');
        $this->addSql('DROP TABLE telegram_chat_project');
    }
}
