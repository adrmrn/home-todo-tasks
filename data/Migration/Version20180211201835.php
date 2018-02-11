<?php declare(strict_types=1);

namespace Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180211201835 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $groupTable = $schema->getTable('group_');

        // Board table
        $boardTable = $schema->createTable('board');
        $boardTable->addColumn('id', 'uuid');
        $boardTable->addColumn('group_id', 'uuid');
        $boardTable->addColumn('name', 'string', ['notnull' => TRUE, 'length' => 255]);
        $boardTable->setPrimaryKey(['id']);
        $boardTable->addForeignKeyConstraint($groupTable, ["group_id"], ["id"], ["onDelete" => "CASCADE"], 'group_id_fkey');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

        $schema->dropTable('board');
    }
}