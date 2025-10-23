<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

class PagesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // Componentes essenciais
        $this->loadComponent('Flash');
    }

    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException
     * @throws \Cake\View\Exception\MissingTemplateException
     * @throws \Cake\Http\Exception\NotFoundException
     */
    public function display(string ...$path): ?Response
    {
        if (empty($path) || $path[0] === 'home') {
            $this->loadDashboardData();
        }

        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }

        $page = $subpage = null;
        if (!empty($path[0])) $page = $path[0];
        if (!empty($path[1])) $subpage = $path[1];
        $this->set(compact('page', 'subpage'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    /**
     * Carrega os dados para o dashboard
     */
    private function loadDashboardData(): void
    {
        // Carregar os modelos manualmente
        $this->Maquinas = $this->fetchTable('Maquinas');
        $this->Equipamentos = $this->fetchTable('Equipamentos');
        $this->Checklists = $this->fetchTable('Checklists');
        $this->Users = $this->fetchTable('Users');

        // Contagens básicas
        $this->set('maquinasCount', $this->Maquinas->find()->count());
        $this->set('equipamentosCount', $this->Equipamentos->find()->count());
        $this->set('checklistsCount', $this->Checklists->find()->count());

        // Apenas admin vê contagem de usuários
        $user = $this->request->getAttribute('identity');
        if ($user && $user->role === 'admin') {
            $this->set('usersCount', $this->Users->find()->count());
        }

        // Últimos 10 checklists, ordenando por data_carregamento
        $checklists = $this->Checklists->find()
            ->order(['data_carregamento' => 'DESC'])
            ->limit(10)
            ->all();
        $this->set('checklists', $checklists);
    }
}
