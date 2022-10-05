<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004071441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY game_ibfk_1');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY game_ibfk_2');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY game_ibfk_3');
        $this->addSql('DROP INDEX winner ON game');
        $this->addSql('DROP INDEX score_player_a ON game');
        $this->addSql('DROP INDEX score_player_b ON game');
        $this->addSql('DROP INDEX IDX_232B318C1916420B ON game');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD CONSTRAINT game_ibfk_1 FOREIGN KEY (score_player_a) REFERENCES score (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT game_ibfk_2 FOREIGN KEY (score_player_b) REFERENCES score (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT game_ibfk_3 FOREIGN KEY (winner) REFERENCES player (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX winner ON game (winner)');
        $this->addSql('CREATE INDEX score_player_a ON game (score_player_a, score_player_b)');
        $this->addSql('CREATE INDEX score_player_b ON game (score_player_b)');
        $this->addSql('CREATE INDEX IDX_232B318C1916420B ON game (score_player_a)');
    }
}
