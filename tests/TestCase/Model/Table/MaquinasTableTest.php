<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MaquinasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MaquinasTable Test Case
 */
class MaquinasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MaquinasTable
     */
    protected $Maquinas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Maquinas',
        'app.Checklists',
        'app.Equipamentos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Maquinas') ? [] : ['className' => MaquinasTable::class];
        $this->Maquinas = $this->getTableLocator()->get('Maquinas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Maquinas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\MaquinasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
