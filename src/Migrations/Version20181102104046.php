<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181102104046 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE backend_user_groups (backend_user_id INT NOT NULL, backend_group_id INT NOT NULL, INDEX IDX_C6AE46769F66D4CC (backend_user_id), INDEX IDX_C6AE4676ECDB3810 (backend_group_id), PRIMARY KEY(backend_user_id, backend_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backend_parameter (ck VARCHAR(255) NOT NULL, identify VARCHAR(255) NOT NULL, parameter LONGTEXT DEFAULT NULL, PRIMARY KEY(ck, identify)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backend_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE backend_user_groups ADD CONSTRAINT FK_C6AE46769F66D4CC FOREIGN KEY (backend_user_id) REFERENCES backend_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backend_user_groups ADD CONSTRAINT FK_C6AE4676ECDB3810 FOREIGN KEY (backend_group_id) REFERENCES backend_group (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE parameter');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE backend_user_groups DROP FOREIGN KEY FK_C6AE4676ECDB3810');
        $this->addSql('CREATE TABLE parameter (ck VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, identify VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, parameter LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(ck, identify)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE backend_user_groups');
        $this->addSql('DROP TABLE backend_parameter');
        $this->addSql('DROP TABLE backend_group');
    }
}
