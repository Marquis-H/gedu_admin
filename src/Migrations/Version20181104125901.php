<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181104125901 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE backend_posts (id INT AUTO_INCREMENT NOT NULL, postType VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT NOT NULL, url VARCHAR(255) DEFAULT NULL, extra LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, created_by VARCHAR(255) NOT NULL, updated_by VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, new_window TINYINT(1) DEFAULT NULL, other_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backend_page (id INT NOT NULL, path VARCHAR(255) NOT NULL, banner VARCHAR(255) DEFAULT NULL, component VARCHAR(255) DEFAULT NULL, extra LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', online_at DATETIME DEFAULT NULL, offline_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, created_by VARCHAR(255) NOT NULL, updated_by VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, nav_title VARCHAR(255) DEFAULT NULL, other_banner VARCHAR(255) DEFAULT NULL, summary LONGTEXT DEFAULT NULL, content LONGTEXT DEFAULT NULL, meta_title LONGTEXT DEFAULT NULL, keywords LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1BF396750 FOREIGN KEY (id) REFERENCES backend_posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backend_page ADD CONSTRAINT FK_95EA3807BF396750 FOREIGN KEY (id) REFERENCES backend_posts (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F1BF396750');
        $this->addSql('ALTER TABLE backend_page DROP FOREIGN KEY FK_95EA3807BF396750');
        $this->addSql('DROP TABLE backend_posts');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE backend_page');
    }
}
