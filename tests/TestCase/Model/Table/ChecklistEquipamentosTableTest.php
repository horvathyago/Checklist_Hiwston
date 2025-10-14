<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChecklistEquipamentosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChecklistEquipamentosTable Test Case
 */
class ChecklistEquipamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChecklistEquipamentosTable
     */
    protected $ChecklistEquipamentos;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ChecklistEquipamentos',
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
        $config = $this->getTableLocator()->exists('ChecklistEquipamentos') ? [] : ['className' => ChecklistEquipamentosTable::class];
        $this->ChecklistEquipamentos = $this->getTableLocator()->get('ChecklistEquipamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ChecklistEquipamentos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ChecklistEquipamentosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ChecklistEquipamentosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
