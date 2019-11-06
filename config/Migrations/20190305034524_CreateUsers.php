<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $table = $this->table('users', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'limit' => 11
        ]);
        $table->addColumn('firstname', 'string', ['limit' => 100, 'default' => null, 'null' => true]);
        $table->addColumn('lastname', 'string', ['limit' => 100, 'default' => null, 'null' => true]);
        $table->addColumn('email', 'string', ['default' => null, 'null' => true]);
        $table->addColumn('password', 'string', ['default' => null, 'null' => true]);
        $table->addColumn('is_active', 'boolean', ['default' => null, 'null' => true]);
        $table->addColumn('role', 'string', ['limit' => 20, 'default' => null, 'null' => true]);
        $table->addColumn('last_login', 'datetime', ['default' => null, 'null' => true]);
        $table->addColumn('last_edit', 'datetime', ['default' => null, 'null' => true]);
        $table->addColumn('created', 'datetime', ['default' => null, 'null' => true]);
        $table->addColumn('modified', 'datetime', ['default' => null, 'null' => true]);
        $table->create();
    }
}
