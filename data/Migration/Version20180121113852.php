<?php declare(strict_types=1);

namespace Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180121113852 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $table = $schema->createTable('event_store');
        $table->addColumn('id', 'bigint', ['notnull' => TRUE, 'autoincrement' => TRUE]);
        $table->addColumn('domain', 'string', ['notnull' => TRUE, 'length' => 128]);
        $table->addColumn('name', 'string', ['notnull' => TRUE, 'length' => 70]);
        $table->addColumn('entity_id', 'uuid', ['notnull' => TRUE]);
        $table->addColumn('data', 'json');
        $table->addColumn('occurred_at', 'datetime');
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema)
    {
        throw new \RuntimeException('No way to go down!');

        $schema->dropTable('event_store');
    }
}
