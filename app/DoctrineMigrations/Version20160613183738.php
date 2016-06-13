<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160613183738 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE purchase_product (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, purchase_id INT DEFAULT NULL, cost NUMERIC(8, 2) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_C890CED44584665A (product_id), INDEX IDX_C890CED4558FBEB9 (purchase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, phone VARCHAR(255) DEFAULT NULL, lname VARCHAR(255) DEFAULT NULL, fname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, pindex VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, address LONGTEXT DEFAULT NULL, delivery_at DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE purchase_product ADD CONSTRAINT FK_C890CED44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE purchase_product ADD CONSTRAINT FK_C890CED4558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('ALTER TABLE lesson CHANGE filename filename VARCHAR(255) NOT NULL, CHANGE is_hidden is_hidden SMALLINT NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE title title VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE purchase_product DROP FOREIGN KEY FK_C890CED4558FBEB9');
        $this->addSql('DROP TABLE purchase_product');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('ALTER TABLE lesson CHANGE filename filename VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE title title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE description description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE is_hidden is_hidden SMALLINT DEFAULT NULL');
    }
}
