<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubscribersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SubscribersTable Test Case
 */
class SubscribersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SubscribersTable
     */
    public $Subscribers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Subscribers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Subscribers') ? [] : ['className' => SubscribersTable::class];
        $this->Subscribers = TableRegistry::getTableLocator()->get('Subscribers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Subscribers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
