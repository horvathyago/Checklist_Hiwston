<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Auth\DefaultPasswordHasher;

class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        // Carregar componentes necessários
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Flash');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Se o usuário já está logado e tenta acessar login, redireciona para dashboard
        if ($this->Authentication->getIdentity() && $this->request->getParam('action') === 'login') {
            return $this->redirect(['controller' => 'Checklists', 'action' => 'index']);
        }

        // Permitir acesso público apenas a login, add e logout
        $this->Authentication->allowUnauthenticated(['login', 'add', 'logout']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        // Se já está autenticado, redireciona para a página principal
        if ($result && $result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? ['controller' => 'Checklists', 'action' => 'index'];
            return $this->redirect($target);
        }

        // Se fez POST e não está válido, mostra erro
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Usuário ou senha incorretos.');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['action' => 'login']);
    }

    public function index()
    {
        // Buscar contagens para os cards do dashboard
        $maquinasCount = $this->fetchTable('Maquinas')->find()->count();
        $equipamentosCount = $this->fetchTable('Equipamentos')->find()->count();
        $checklistsCount = $this->fetchTable('Checklists')->find()->count();
        
        // Contar usuários apenas se for admin
        $user = $this->Authentication->getIdentity();
        $usersCount = null;
        if ($user && $user->role === 'admin') {
            $usersCount = $this->Users->find()->count();
        }

        $query = $this->Users->find()
            ->order(['Users.id' => 'ASC']);
        $maquinas = $this->paginate($query);

        $this->set(compact('maquinas', 'maquinasCount', 'equipamentosCount', 'checklistsCount', 'usersCount'));
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if (!empty($user->password)) {
                $user->password = (new DefaultPasswordHasher())->hash($user->password);
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário criado com sucesso.'));
                
                // Se já está logado, vai para index de usuários, senão para login
                if ($this->Authentication->getIdentity()) {
                    return $this->redirect(['action' => 'index']);
                } else {
                    return $this->redirect(['action' => 'login']);
                }
            }
            $this->Flash->error(__('Erro ao criar usuário. Por favor, tente novamente.'));
        }

        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if (!empty($user->password)) {
                $user->password = (new DefaultPasswordHasher())->hash($user->password);
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário atualizado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao atualizar usuário.'));
        }

        $this->set(compact('user'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Usuário deletado com sucesso.'));
        } else {
            $this->Flash->error(__('Erro ao deletar usuário.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}