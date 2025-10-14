<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ChecklistEquipamentos Controller
 *
 * @property \App\Model\Table\ChecklistEquipamentosTable $ChecklistEquipamentos
 */
class ChecklistEquipamentosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ChecklistEquipamentos->find()
            ->contain(['Checklists', 'Equipamentos']);
        $checklistEquipamentos = $this->paginate($query);

        $this->set(compact('checklistEquipamentos'));
    }

    /**
     * View method
     *
     * @param string|null $id Checklist Equipamento id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $checklistEquipamento = $this->ChecklistEquipamentos->get($id, contain: ['Checklists', 'Equipamentos']);
        $this->set(compact('checklistEquipamento'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $checklistEquipamento = $this->ChecklistEquipamentos->newEmptyEntity();
        if ($this->request->is('post')) {
            $checklistEquipamento = $this->ChecklistEquipamentos->patchEntity($checklistEquipamento, $this->request->getData());
            if ($this->ChecklistEquipamentos->save($checklistEquipamento)) {
                $this->Flash->success(__('The checklist equipamento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The checklist equipamento could not be saved. Please, try again.'));
        }
        $checklists = $this->ChecklistEquipamentos->Checklists->find('list', limit: 200)->all();
        $equipamentos = $this->ChecklistEquipamentos->Equipamentos->find('list', limit: 200)->all();
        $this->set(compact('checklistEquipamento', 'checklists', 'equipamentos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Checklist Equipamento id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $checklistEquipamento = $this->ChecklistEquipamentos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $checklistEquipamento = $this->ChecklistEquipamentos->patchEntity($checklistEquipamento, $this->request->getData());
            if ($this->ChecklistEquipamentos->save($checklistEquipamento)) {
                $this->Flash->success(__('The checklist equipamento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The checklist equipamento could not be saved. Please, try again.'));
        }
        $checklists = $this->ChecklistEquipamentos->Checklists->find('list', limit: 200)->all();
        $equipamentos = $this->ChecklistEquipamentos->Equipamentos->find('list', limit: 200)->all();
        $this->set(compact('checklistEquipamento', 'checklists', 'equipamentos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Checklist Equipamento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $checklistEquipamento = $this->ChecklistEquipamentos->get($id);
        if ($this->ChecklistEquipamentos->delete($checklistEquipamento)) {
            $this->Flash->success(__('The checklist equipamento has been deleted.'));
        } else {
            $this->Flash->error(__('The checklist equipamento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
