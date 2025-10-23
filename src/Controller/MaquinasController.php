<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Maquinas Controller
 *
 * @property \App\Model\Table\MaquinasTable $Maquinas
 */
class MaquinasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // Buscar contagens para os cards do dashboard
        $maquinasCount = $this->Maquinas->find()->count();
        $equipamentosCount = $this->fetchTable('Equipamentos')->find()->count();
        $checklistsCount = $this->fetchTable('Checklists')->find()->count();
        
        // Contar usuários apenas se for admin
        $user = $this->Authentication->getIdentity();
        $usersCount = null;
        if ($user && $user->role === 'admin') {
            $usersCount = $this->fetchTable('Users')->find()->count();
        }

        $query = $this->Maquinas->find()
            ->contain(['Equipamentos'])
            ->order(['Maquinas.id' => 'ASC']);
        $maquinas = $this->paginate($query);

        $this->set(compact('maquinas', 'maquinasCount', 'equipamentosCount', 'checklistsCount', 'usersCount'));
    }

    /**
     * View method
     *
     * @param string|null $id Maquina id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $maquina = $this->Maquinas->get($id, contain: ['Equipamentos', 'Checklists']);
        $this->set(compact('maquina'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $maquina = $this->Maquinas->newEmptyEntity();
        if ($this->request->is('post')) {
            $maquina = $this->Maquinas->patchEntity($maquina, $this->request->getData());
            if ($this->Maquinas->save($maquina)) {
                $this->Flash->success(__('The maquina has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The maquina could not be saved. Please, try again.'));
        }
        $equipamentos = $this->Maquinas->Equipamentos->find('list', limit: 200)->all();
        $this->set(compact('maquina', 'equipamentos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Maquina id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $maquina = $this->Maquinas->get($id, contain: ['Equipamentos']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $maquina = $this->Maquinas->patchEntity($maquina, $this->request->getData());
            if ($this->Maquinas->save($maquina)) {
                $this->Flash->success(__('The maquina has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The maquina could not be saved. Please, try again.'));
        }
        $equipamentos = $this->Maquinas->Equipamentos->find('list', limit: 200)->all();
        $this->set(compact('maquina', 'equipamentos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Maquina id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $maquina = $this->Maquinas->get($id);
        if ($this->Maquinas->delete($maquina)) {
            $this->Flash->success(__('The maquina has been deleted.'));
        } else {
            $this->Flash->error(__('The maquina could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
