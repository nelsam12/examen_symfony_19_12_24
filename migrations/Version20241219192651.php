<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219192651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classe (id SERIAL NOT NULL, libelle_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8F87BF9625DD318D ON classe (libelle_id)');
        $this->addSql('CREATE TABLE cours (id SERIAL NOT NULL, professeur_id INT DEFAULT NULL, niveau_id INT DEFAULT NULL, module VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CBAB22EE9 ON cours (professeur_id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CB3E9C81 ON cours (niveau_id)');
        $this->addSql('CREATE TABLE etudiant (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE inscription (id SERIAL NOT NULL, annee_scolaire VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE niveau (id SERIAL NOT NULL, nom_niveau VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE professeur (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE session (id SERIAL NOT NULL, cours_id INT DEFAULT NULL, date DATE NOT NULL, heure_debut TIME(0) WITHOUT TIME ZONE NOT NULL, heure_fin TIME(0) WITHOUT TIME ZONE NOT NULL, salle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D044D5D47ECF78B0 ON session (cours_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF9625DD318D FOREIGN KEY (libelle_id) REFERENCES niveau (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D47ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE classe DROP CONSTRAINT FK_8F87BF9625DD318D');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9CBAB22EE9');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9CB3E9C81');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D47ECF78B0');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
