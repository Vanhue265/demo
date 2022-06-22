<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621183858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE buyer (id INT AUTO_INCREMENT NOT NULL, buyername VARCHAR(255) NOT NULL, buyerphone VARCHAR(255) NOT NULL, buyeraddress VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pet (id INT AUTO_INCREMENT NOT NULL, buyer_id INT DEFAULT NULL, receipt_id INT DEFAULT NULL, petname VARCHAR(255) NOT NULL, petgender VARCHAR(255) NOT NULL, pettype VARCHAR(255) NOT NULL, petimage VARCHAR(255) NOT NULL, INDEX IDX_E4529B856C755722 (buyer_id), UNIQUE INDEX UNIQ_E4529B852B5CA896 (receipt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pet_staff (pet_id INT NOT NULL, staff_id INT NOT NULL, INDEX IDX_EF123331966F7FB6 (pet_id), INDEX IDX_EF123331D4D57CD (staff_id), PRIMARY KEY(pet_id, staff_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receipt (id INT AUTO_INCREMENT NOT NULL, buyer_id INT DEFAULT NULL, petname VARCHAR(255) NOT NULL, buyername VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, datecreate DATE NOT NULL, INDEX IDX_5399B6456C755722 (buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff (id INT AUTO_INCREMENT NOT NULL, staffname VARCHAR(255) NOT NULL, staffphone VARCHAR(255) NOT NULL, staffaddress VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B856C755722 FOREIGN KEY (buyer_id) REFERENCES buyer (id)');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B852B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id)');
        $this->addSql('ALTER TABLE pet_staff ADD CONSTRAINT FK_EF123331966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pet_staff ADD CONSTRAINT FK_EF123331D4D57CD FOREIGN KEY (staff_id) REFERENCES staff (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B6456C755722 FOREIGN KEY (buyer_id) REFERENCES buyer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B856C755722');
        $this->addSql('ALTER TABLE receipt DROP FOREIGN KEY FK_5399B6456C755722');
        $this->addSql('ALTER TABLE pet_staff DROP FOREIGN KEY FK_EF123331966F7FB6');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B852B5CA896');
        $this->addSql('ALTER TABLE pet_staff DROP FOREIGN KEY FK_EF123331D4D57CD');
        $this->addSql('DROP TABLE buyer');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE pet_staff');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('DROP TABLE staff');
    }
}
