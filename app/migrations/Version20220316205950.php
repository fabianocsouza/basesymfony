<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220316205950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE registration (id INT AUTO_INCREMENT NOT NULL, course_id INT DEFAULT NULL, student_id INT NOT NULL, enrolment_date DATETIME NOT NULL, INDEX IDX_62A8A7A7591CC992 (course_id), INDEX IDX_62A8A7A7CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student ADD enrolment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33D6A39F64 FOREIGN KEY (enrolment_id) REFERENCES registration (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33D6A39F64 ON student (enrolment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33D6A39F64');
        $this->addSql('DROP TABLE registration');
        $this->addSql('DROP INDEX IDX_B723AF33D6A39F64 ON student');
        $this->addSql('ALTER TABLE student DROP enrolment_id');
    }
}
