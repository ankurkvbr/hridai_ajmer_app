<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CmsPageTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CmsPageTable Test Case
 */
class CmsPageTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CmsPageTable
     */
    public $CmsPage;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cms_page',
        'app.cms_page_translation'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CmsPage') ? [] : ['className' => 'App\Model\Table\CmsPageTable'];
        $this->CmsPage = TableRegistry::get('CmsPage', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CmsPage);

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
