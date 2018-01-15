<?php declare(strict_types=1);

namespace Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180115195506 extends AbstractMigration
{
    /**
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('user_');
        $table->addColumn('id', 'uuid');
        $table->addColumn('name', 'string', ['notnull' => TRUE, 'length' => 70]);
        $table->addColumn('email', 'string', [
            'notnull'             => TRUE,
            'length'              => 255,
            'customSchemaOptions' => ['unique' => TRUE],
        ]);
        $table->addColumn('password_hash', 'string', ['notnull' => TRUE, 'length' => 60]);
        $table->setPrimaryKey(['id']);
    }

    /**
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function down(Schema $schema)
    {
        throw new \RuntimeException('No way to go down!');

        $schema->dropTable('user_');
    }
}
