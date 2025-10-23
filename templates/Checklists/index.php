<?php
$this->assign('title', 'Dashboard - Sistema de Checklist');
$this->Html->css([
    'variables',
    'reset', 
    'layout',
    'sidebar',
    'header',
    'buttons',
    'cards',
    'tables',
    'forms',
    'dark-mode',
    'utilities',
    'professional'
], ['block' => true]);

$this->Html->script('dashboard', ['block' => true]);

// VERIFICAÇÃO DO USUÁRIO ADMIN - CORRIGIDO
$isAdmin = false;
$currentUser = null;

if ($this->request->getAttribute('identity')) {
    $currentUser = $this->request->getAttribute('identity');
    
    // CONDIÇÃO CORRIGIDA - campo 'role' com valor 'admin'
    $isAdmin = ($currentUser->role === 'admin');
}

?>

<div class="app-container">
    <!-- Sidebar -->
    <nav class="sidebar collapsed" id="sidebar">
        <div class="sidebar-header">
            <img src="<?= $this->Url->image('logo-hiwston.png') ?>" alt="Logo" class="sidebar-logo">
        </div>

        <div class="sidebar-nav">
            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'index']) ?>" class="sidebar-link active">
                <span class="sidebar-icon">🏠</span><span class="sidebar-text">Dashboard</span>
            </a>
            
            <?php if ($isAdmin): ?>
            <!-- BOTÃO APENAS PARA ADMIN -->
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="sidebar-link admin-only">
                <span class="sidebar-icon">👥</span><span class="sidebar-text">Usuários</span>
            </a>
            <?php endif; ?>
            
            <a href="<?= $this->Url->build(['controller' => 'Maquinas', 'action' => 'index']) ?>" class="sidebar-link">
                <span class="sidebar-icon">🏭</span><span class="sidebar-text">Máquinas</span>
            </a>
            <a href="<?= $this->Url->build(['controller' => 'Equipamentos', 'action' => 'index']) ?>" class="sidebar-link">
                <span class="sidebar-icon">🔧</span><span class="sidebar-text">Equipamentos</span>
            </a>
            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'add']) ?>" class="sidebar-link">
                <span class="sidebar-icon">➕</span><span class="sidebar-text">Novo Checklist</span>
            </a>

            <!-- BOTÃO DE LOGOUT -->
            <div class="sidebar-logout">
                <?= $this->Form->postLink(
                    '<span class="sidebar-icon">🚪</span><span class="sidebar-text">Sair</span>',
                    ['controller' => 'Users', 'action' => 'logout'],
                    [
                        'escape' => false,
                        'class' => 'sidebar-link logout-link',
                        'confirm' => 'Tem certeza que deseja sair?'
                    ]
                ) ?>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="main-content" id="mainContent">
        <header class="dashboard-header">
            <button class="menu-toggle" id="menuToggle">☰</button>
            <div class="header-center">
                <img src="<?= $this->Url->image('logo-hiwston.png') ?>" alt="Logo da Empresa" class="header-logo">
            </div>
            <div class="header-right">
                <button id="themeToggle" class="theme-toggle" title="Alternar tema">🌙</button>
                <span class="current-time"><?= date('d/m/Y') ?></span>
                
                <!-- Mostrar role do usuário -->
                <?php if ($currentUser): ?>
                <div class="user-info">
                    <span class="user-name"><?= h($currentUser->username ?? $currentUser->email) ?></span>
                    <span class="user-role">
                        <?= $isAdmin ? '👑 Admin' : '👤 Usuário' ?>
                    </span>
                    <?= $this->Form->postLink(
                        '🚪 Sair',
                        ['controller' => 'Users', 'action' => 'logout'],
                        [
                            'class' => 'btn-logout',
                            'confirm' => 'Tem certeza que deseja sair?'
                        ]
                    ) ?>
                </div>
                <?php endif; ?>
            </div>
        </header>

        <div class="dashboard-main content-wrapper">
            <!-- Cards com links -->
            <section class="stats-section">
                <h2 class="section-title">Resumo Geral</h2>
                <div class="stats-grid <?= $isAdmin ? 'has-admin-cards' : '' ?>">
                    <a href="<?= $this->Url->build(['controller' => 'Maquinas', 'action' => 'index']) ?>" class="stat-card-link">
                        <div class="stat-card">
                            <div class="stat-icon">🏭</div>
                            <div class="stat-info">
                                <span class="stat-number"><?= $maquinasCount ?? '0' ?></span>
                                <span class="stat-label">Máquinas</span>
                            </div>
                        </div>
                    </a>
                    <a href="<?= $this->Url->build(['controller' => 'Equipamentos', 'action' => 'index']) ?>" class="stat-card-link">
                        <div class="stat-card">
                            <div class="stat-icon">🔧</div>
                            <div class="stat-info">
                                <span class="stat-number"><?= $equipamentosCount ?? '0' ?></span>
                                <span class="stat-label">Equipamentos</span>
                            </div>
                        </div>
                    </a>
                    <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'index']) ?>" class="stat-card-link">
                        <div class="stat-card">
                            <div class="stat-icon">📋</div>
                            <div class="stat-info">
                                <span class="stat-number"><?= $checklistsCount ?? '0' ?></span>
                                <span class="stat-label">Checklists</span>
                            </div>
                        </div>
                    </a>
                    
                    <?php if ($isAdmin && isset($usersCount)): ?>
                    <!-- Card adicional apenas para admin -->
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="stat-card-link admin-card">
                        <div class="stat-card">
                            <div class="stat-icon">👥</div>
                            <div class="stat-info">
                                <span class="stat-number"><?= $usersCount ?></span>
                                <span class="stat-label">Usuários</span>
                            </div>
                        </div>
                    </a>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Tabela -->
            <section class="checklist-section table-container">
                <div class="section-header flex-between">
                    <h2 class="section-title">Todos os Checklists</h2>
                    <div class="filters flex-gap">
                        <input type="text" placeholder="Buscar por nome..." class="filter-input form-input">
                        <input type="date" class="filter-input form-input">
                        <button class="filter-btn btn btn-primary">Buscar</button>
                        
                        <?php if ($isAdmin): ?>
                        <!-- Botão de ação rápida para admin -->
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="btn btn-secondary admin-btn">
                           ➕ Novo Usuário
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="checklist-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($checklists)): ?>
                                <?php foreach ($checklists as $checklist): ?>
                                    <tr>
                                        <td><?= $checklist->id ?></td>
                                        <td><?= h($checklist->cliente) ?></td>
                                        <td>
                                            <?php 
                                            if ($checklist->data instanceof \Cake\I18n\Time || $checklist->data instanceof \Cake\I18n\Date) {
                                                echo $checklist->data->format('d/m/Y');
                                            } else {
                                                echo date('d/m/Y', strtotime($checklist->data));
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?= strtolower($checklist->status) ?>">
                                                <?= h($checklist->status) ?>
                                            </span>
                                        </td>
                                        <td class="actions">
                                            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'view', $checklist->id]) ?>" 
                                            class="btn-view btn-action" 
                                            title="Visualizar"
                                            data-checklist-id="<?= $checklist->id ?>">👁️</a>
                                            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'edit', $checklist->id]) ?>" 
                                            class="btn-edit btn-action" title="Editar">✏️</a>
                                            
                                            <?php if ($isAdmin): ?>
                                            <!-- Apenas admin pode excluir -->
                                            <?= $this->Form->postLink('🗑️', 
                                                ['controller' => 'Checklists', 'action' => 'delete', $checklist->id], 
                                                ['confirm' => 'Tem certeza que deseja excluir este checklist?', 
                                                'class' => 'btn-delete btn-action', 
                                                'title' => 'Excluir', 
                                                'escape' => false]
                                            ) ?>
                                            <?php else: ?>
                                            <!-- Usuário normal não vê o botão de excluir -->
                                            <span class="btn-action disabled-action" title="Apenas administradores podem excluir">🗑️</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="empty-row">Nenhum checklist encontrado</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</div>