<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CmsPageTranslationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CmsPageTranslationTable Test Case
 */
class CmsPageTranslationTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CmsPageTranslationTable
     */
    public $CmsPageTranslation;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cms_page_translation',
        'app.cms_page'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CmsPageTranslation') ? [] : ['className' => 'App\Model\Table\CmsPageTranslationTable'];
        $this->CmsPageTranslation = TableRegistry::get('CmsPageTranslation', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CmsPageTranslation);

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
