<?php
namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\SamplesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\SamplesTable Test Case
 */
class SamplesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Admin\Model\Table\SamplesTable
     */
    public $Samples;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.admin.samples'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Samples') ? [] : ['className' => SamplesTable::class];
        $this->Samples = TableRegistry::get('Samples', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Samples);

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
