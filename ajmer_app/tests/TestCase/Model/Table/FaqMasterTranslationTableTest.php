<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaqMasterTranslationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaqMasterTranslationTable Test Case
 */
class FaqMasterTranslationTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FaqMasterTranslationTable
     */
    public $FaqMasterTranslation;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.faq_master_translation',
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
        $config = TableRegistry::exists('FaqMasterTranslation') ? [] : ['className' => 'App\Model\Table\FaqMasterTranslationTable'];
        $this->FaqMasterTranslation = TableRegistry::get('FaqMasterTranslation', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FaqMasterTranslation);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
