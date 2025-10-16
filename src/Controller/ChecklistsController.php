<?php
declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Log\Log;

/**
 * Checklists Controller
 *
 * @property \App\Model\Table\ChecklistsTable $Checklists
 */
class ChecklistsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Checklists->find()
            ->contain(['Maquinas']);
        $checklists = $this->paginate($query);

        $this->set(compact('checklists'));
    }

    /**
     * View method
     *
     * @param string|null $id Checklist id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $checklist = $this->Checklists->get($id, contain: ['Maquinas', 'ChecklistEquipamentos']);
        $this->set(compact('checklist'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $checklist = $this->Checklists->newEmptyEntity();
        if ($this->request->is('post')) {
            $checklist = $this->Checklists->patchEntity($checklist, $this->request->getData());

            if ($this->Checklists->save($checklist)) {
                if ($this->request->getData('checklist_equipamentos')) {
                    foreach ($this->request->getData('checklist_equipamentos') as $equipamentoData) {
                        if (isset($equipamentoData['_joinData'])) {
                            $checklistEquipamento = $this->Checklists->ChecklistEquipamentos->newEntity([
                                'checklist_id' => $checklist->id,
                                'equipamento_id' => $equipamentoData['equipamento_id'],
                                'quantidade' => $equipamentoData['_joinData']['quantidade'],
                            ]);
                            $this->Checklists->ChecklistEquipamentos->save($checklistEquipamento);
                        }
                    }
                }
                $this->Flash->success(__('The checklist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The checklist could not be saved. Please, try again.'));
        }
        $maquinas = $this->Checklists->Maquinas->find('list', limit: 200)->all();
        $this->set(compact('checklist', 'maquinas'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Checklist id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $checklist = $this->Checklists->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $checklist = $this->Checklists->patchEntity($checklist, $this->request->getData());
            if ($this->Checklists->save($checklist)) {
                $this->Flash->success(__('The checklist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The checklist could not be saved. Please, try again.'));
        }
        $maquinas = $this->Checklists->Maquinas->find('list', limit: 200)->all();
        $this->set(compact('checklist', 'maquinas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Checklist id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $checklist = $this->Checklists->get($id);
        if ($this->Checklists->delete($checklist)) {
            $this->Flash->success(__('The checklist has been deleted.'));
        } else {
            $this->Flash->error(__('The checklist could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getEquipamentos()
    {
        $this->request->allowMethod(['post']);
        $maquinaId = $this->request->getData('maquina_id');
        $maquina = $this->Checklists->Maquinas->get($maquinaId, contain: ['Equipamentos']);

        $this->viewBuilder()->setOption('serialize', ['equipamentos']);
        $this->set('equipamentos', $maquina->equipamentos);
        $this->viewBuilder()->setLayout('ajax');
        $this->render(false);

        return $this->response->withType('application/json')->withStringBody(json_encode($maquina->equipamentos));
    }

    public function generatePdf($id = null)
    {
        // 1. Carregar os dados
        $checklist = $this->Checklists->get($id, contain: ['Maquinas', 'ChecklistEquipamentos.Equipamentos']);
        $this->set(compact('checklist'));

        // 2. Configurar a view e renderizar
        // 2. Configurar a view e renderizar manualmente
        $view = new \Cake\View\View();
        $view->setTemplatePath('Checklists/pdf');
        $view->setTemplate('checklist_pdf');
        $view->set('checklist', $checklist);
        $view->disableAutoLayout();

        $html = $view->render();
        // 3. Gerar o PDF com Dompdf
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('tempDir', TMP);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 4. Enviar o PDF para o navegador
        $this->response = $this->response->withStringBody($dompdf->output());
        $this->response = $this->response->withType('application/pdf');
        $this->response = $this->response->withDownload('checklist_' . $id . '.pdf');

        return $this->response;
    }
}
