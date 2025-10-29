<?php
declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Log\Log;
use Cake\Event\EventInterface;

/**
 * Checklists Controller
 *
 * @property \App\Model\Table\ChecklistsTable $Checklists
 */
class ChecklistsController extends AppController
{
    /**
     * Initialization method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
    }

    /**
     * Before filter method
     *
     * @param \Cake\Event\EventInterface $event The event
     * @return void
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Todas as actions deste controller exigem autenticação
        $this->Authentication->addUnauthenticatedActions([]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // Buscar contagens para os cards do dashboard
        $maquinasCount = $this->fetchTable('Maquinas')->find()->count();
        $equipamentosCount = $this->fetchTable('Equipamentos')->find()->count();
        $checklistsCount = $this->Checklists->find()->count();
        
        // Contar usuários apenas se for admin
        $user = $this->Authentication->getIdentity();
        $usersCount = null;
        if ($user && $user->role === 'admin') {
            $usersCount = $this->fetchTable('Users')->find()->count();
        }

        $query = $this->Checklists->find()
            ->contain(['Maquinas']);
        $checklists = $this->paginate($query);

        $this->set(compact('checklists', 'maquinasCount', 'equipamentosCount', 'checklistsCount', 'usersCount'));
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
        $checklist = $this->Checklists->get($id, [
            'contain' => ['ChecklistEquipamentos', 'Maquinas']
        ]);

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
        }

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
            // Processar equipamentos selecionados
            $data = $this->request->getData();
            
            // Filtrar apenas os equipamentos que foram marcados (checked = 1)
            if (isset($data['checklist_equipamentos'])) {
                $equipamentosSelecionados = [];
                foreach ($data['checklist_equipamentos'] as $index => $equipamento) {
                    if (isset($equipamento['checked']) && $equipamento['checked'] == '1') {
                        // Adicionar apenas se estiver marcado
                        $equipamentosSelecionados[] = [
                            'equipamento_id' => $equipamento['equipamento_id'],
                            'quantidade' => $equipamento['quantidade'] ?? 1
                        ];
                    }
                }
                $data['checklist_equipamentos'] = $equipamentosSelecionados;
            }
            
            $checklist = $this->Checklists->patchEntity(
                $checklist,
                $data,
                ['associated' => ['ChecklistEquipamentos']]
            );
            
            if ($this->Checklists->save($checklist)) {
                $this->Flash->success(__('Checklist salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o checklist. Por favor, tente novamente.'));
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
        
        // Verificar se é admin para permitir exclusão
        $user = $this->Authentication->getIdentity();
        if (!$user || $user->role !== 'admin') {
            $this->Flash->error(__('Você não tem permissão para excluir checklists.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->Checklists->delete($checklist)) {
            $this->Flash->success(__('The checklist has been deleted.'));
        } else {
            $this->Flash->error(__('The checklist could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Get equipamentos method - CORRIGIDO
     *
     * @return \Cake\Http\Response|null
     */
    public function getEquipamentos()
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;
        
        $maquinaId = $this->request->getData('maquina_id');
        
        if (!$maquinaId) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode([]));
        }
        
        try {
            // Verificar se a máquina existe
            $maquinaExists = $this->Checklists->Maquinas->exists(['id' => $maquinaId]);
            
            if (!$maquinaExists) {
                return $this->response->withType('application/json')
                    ->withStringBody(json_encode([]));
            }
            
            $equipamentos = $this->Checklists->Maquinas->Equipamentos->find()
                ->where(['maquina_id' => $maquinaId])
                ->select(['id', 'nome', 'descricao', 'quantidade_padrao'])
                ->toArray();

            return $this->response->withType('application/json')
                ->withStringBody(json_encode($equipamentos));
                
        } catch (\Exception $e) {
            // Log do erro
            Log::error('Erro ao carregar equipamentos: ' . $e->getMessage());
            
            return $this->response->withType('application/json')
                ->withStringBody(json_encode([]));
        }
    }

    /**
     * Generate PDF method
     *
     * @param string|null $id Checklist id.
     * @return \Cake\Http\Response|null
     */
    public function generatePdf($id = null)
    {
        // 1. Carregar os dados
        $checklist = $this->Checklists->get($id, contain: ['Maquinas', 'ChecklistEquipamentos.Equipamentos']);
        $this->set(compact('checklist'));

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