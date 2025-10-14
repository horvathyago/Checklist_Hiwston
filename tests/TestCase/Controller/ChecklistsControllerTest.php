<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ChecklistsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\ChecklistsController Test Case
 *
 * @link \App\Controller\ChecklistsController
 */
class ChecklistsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Checklists',
        'app.Maquinas',
        'app.Equipamentos',
        'app.ChecklistEquipamentos',
        'app.MaquinasEquipamentos',
    ];

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\ChecklistsController::add()
     */
    public function testAdd(): void
    {
        $this->enableCsrfToken();

        $data = [
            'numero_ordem_producao' => 'OP-12345',
            'cliente' => 'Cliente de Teste',
            'data_carregamento' => '2025-10-14',
            'destino' => 'Destino de Teste',
            'maquina_id' => 1,
            'checklist_equipamentos' => [
                ['equipamento_id' => 1, 'quantidade' => 4],
                ['equipamento_id' => 2, 'quantidade' => 4],
            ]
        ];

        $this->post('/checklists/add', $data);

        $this->assertRedirect(['controller' => 'Checklists', 'action' => 'index']);

        $checklists = TableRegistry::getTableLocator()->get('Checklists');
        $query = $checklists->find()->where(['numero_ordem_producao' => $data['numero_ordem_producao']]);
        $this->assertEquals(1, $query->count());

        $checklist = $query->first();
        $checklistEquipamentos = TableRegistry::getTableLocator()->get('ChecklistEquipamentos');
        $query = $checklistEquipamentos->find()->where(['checklist_id' => $checklist->id]);
        $this->assertEquals(2, $query->count());
    }

    public function testGeneratePdf(): void
    {
        $checklists = TableRegistry::getTableLocator()->get('Checklists');
        $checklist = $checklists->newEntity([
            'numero_ordem_producao' => 'OP-PDF',
            'maquina_id' => 1,
            'checklist_equipamentos' => [
                ['equipamento_id' => 1, 'quantidade' => 1]
            ]
        ], ['associated' => ['ChecklistEquipamentos']]);
        $checklists->save($checklist);

        $this->get('/checklists/generate-pdf/' . $checklist->id);

        $this->assertResponseOk();
        $this->assertContentType('application/pdf');
        $this->assertStringStartsWith('%PDF-', (string)$this->_response->getBody());
    }
}