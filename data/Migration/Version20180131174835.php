<?php declare(strict_types=1);

namespace Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180131174835 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // Group table
        $groupTable = $schema->createTable('group_');
        $groupTable->addColumn('id', 'uuid');
        $groupTable->addColumn('name', 'string', ['notnull' => TRUE, 'length' => 255]);
        $groupTable->setPrimaryKey(['id']);

        // Member table
        $memberTable = $schema->createTable('member');
        $memberTable->addColumn('id', 'uuid');
        $memberTable->addColumn('role', 'string', ['notnull' => TRUE, 'length' => 70, 'default' => 'member']);
        $memberTable->setPrimaryKey(['id']);

        // GroupMember table
        $groupMemberTable = $schema->createTable('groups_members');
        $groupMemberTable->addColumn('group_id', 'uuid');
        $groupMemberTable->addColumn('member_id', 'uuid');
        $groupMemberTable->setPrimaryKey(['group_id', 'member_id']);
        $groupMemberTable->addForeignKeyConstraint($groupTable, ['group_id'], ['id'], ['onDelete' => 'CASCADE'], 'group_id_fkey');
        $groupMemberTable->addForeignKeyConstraint($memberTable, ['member_id'], ['id'], ['onDelete' => 'CASCADE'], 'member_id_fkey');
    }

    public function down(Schema $schema)
    {
        throw new \RuntimeException('No way to go down!');

        $schema->dropTable('group_');
        $schema->dropTable('member');
        $schema->dropTable('groups_members');
    }
}
