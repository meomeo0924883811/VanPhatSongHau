<?php
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'firstname' => 'admin',
                'lastname' => 'admin',
                'email' => 'admin@mail.com',
                'password' => '$2y$10$j1oITNl7qkJxlalywepJIuc8KHfbE5XHDj56B/CXGmvh0J8Fe/mIS',//Bliss@1234
                'is_active' => '1',
                'role' => 'admin',
                'last_login' => date('Y-m-d H:i:s'),
                'last_edit' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
