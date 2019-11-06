<?php
use Migrations\AbstractMigration;

class CreateLogUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('log_users', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'limit' => 11
        ]);
        $table->addColumn('user_id', 'integer');
        $table->addColumn('password', 'string');
        $table->addColumn('last_edit', 'datetime', ['default' => null, 'null' => true]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => true]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => true]);
        $table->create();
    }
}
