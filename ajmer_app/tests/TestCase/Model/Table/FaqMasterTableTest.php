<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaqMasterTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaqMasterTable Test Case
 */
class FaqMasterTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FaqMasterTable
     */
    public $FaqMaster;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.faq_master'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('FaqMaster') ? [] : ['className' => 'App\Model\Table\FaqMasterTable'];
        $this->FaqMaster = TableRegistry::get('FaqMaster', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FaqMaster);

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
