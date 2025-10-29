<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Http\Response;

class UsersController extends AppController
{
    // ... (initialize e beforeFilter permanecem inalterados) ...
    
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
        // Permite login e logout sem estar autenticado
        $this->Authentication->addUnauthenticatedActions(['login', 'logout']);
    }

    /**
     * Página de login
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        // Se o usuário já está autenticado, redireciona
        if ($result && $result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? ['controller' => 'Checklists', 'action' => 'index'];
            return $this->redirect($target);
        }

        // Caso o formulário tenha sido enviado e falhou
        if ($this->request->is('post') && (!$result || !$result->isValid())) {
            $this->Flash->error(__('Usuário ou senha incorretos.'));
        }
    }

    /**
     * Logout do sistema
     * @return \Cake\Http\Response|null
     */
   // Na função logout() do UsersController.php

    public function logout(): ?Response
    {
        $result = $this->Authentication->getResult();
        // Apenas desloga se o usuário estiver autenticado
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('Você saiu com sucesso.'));
        }
        return $this->redirect(['action' => 'login']);
    }

    // ... (index, add, edit, delete permanecem inalterados) ...


    /**
     * Index/listagem de usuários (dashboard)
     */
    public function index()
    {
        // Buscar contagens para os cards do dashboard
        $maquinasCount = $this->fetchTable('Maquinas')->find()->count();
        $equipamentosCount = $this->fetchTable('Equipamentos')->find()->count();
        $checklistsCount = $this->fetchTable('Checklists')->find()->count();

        // Contar usuários apenas se for admin
        $user = $this->Authentication->getIdentity();
        $usersCount = null;
        if ($user && property_exists($user, 'role') && $user->role === 'admin') {
            $usersCount = $this->Users->find()->count();
        }

        // Listar usuários (paginado)
        $query = $this->Users->find()->order(['Users.id' => 'ASC']);
        $users = $this->paginate($query);

        // Ajuste das variáveis enviadas para a view
        $this->set(compact('users', 'maquinasCount', 'equipamentosCount', 'checklistsCount', 'usersCount'));
    }

    /**
     * Criar usuário
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // Hash da senha (se foi fornecida)
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

    /**
     * Editar usuário
     */
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

    /**
     * Deletar usuário
     */
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