<?php
$this->assign('title', 'Equipamentos - Sistema de Checklist');
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

// VERIFICAÇÃO DO USUÁRIO ADMIN
$isAdmin = false;
$currentUser = null;
if ($this->request->getAttribute('identity')) {
    $currentUser = $this->request->getAttribute('identity');
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
            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'index']) ?>" class="sidebar-link">
                <span class="sidebar-icon">🏠</span><span class="sidebar-text">Dashboard</span>
            </a>

            <?php if ($isAdmin): ?>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="sidebar-link admin-only">
                <span class="sidebar-icon">👥</span><span class="sidebar-text">Usuários</span>
            </a>
            <?php endif; ?>

            <a href="<?= $this->Url->build(['controller' => 'Maquinas', 'action' => 'index']) ?>" class="sidebar-link">
                <span class="sidebar-icon">🏭</span><span class="sidebar-text">Máquinas</span>
            </a>
            <a href="<?= $this->Url->build(['controller' => 'Equipamentos', 'action' => 'index']) ?>" class="sidebar-link active">
                <span class="sidebar-icon">🔧</span><span class="sidebar-text">Equipamentos</span>
            </a>
            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'add']) ?>" class="sidebar-link">
                <span class="sidebar-icon">➕</span><span class="sidebar-text">Novo Checklist</span>
            </a>

            <div class="sidebar-logout">
                <?= $this->Form->postLink(
                    '<span class="sidebar-icon">🚪</span><span class="sidebar-text">Sair</span>',
                    ['controller' => 'Users', 'action' => 'logout'],
                    ['escape' => false, 'class' => 'sidebar-link logout-link', 'confirm' => 'Tem certeza que deseja sair?']
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

                <?php if ($currentUser): ?>
                <div class="user-info">
                    <span class="user-name"><?= h($currentUser->username ?? $currentUser->email) ?></span>
                    <span class="user-role"><?= $isAdmin ? '👑 Admin' : '👤 Usuário' ?></span>
                    <?= $this->Form->postLink(
                        '🚪 Sair',
                        ['controller' => 'Users', 'action' => 'logout'],
                        ['class' => 'btn-logout', 'confirm' => 'Tem certeza que deseja sair?']
                    ) ?>
                </div>
                <?php endif; ?>
            </div>
        </header>

        <div class="dashboard-main content-wrapper">
            <!-- Cards -->
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
                </div>
            </section>

            <!-- Tabela de Equipamentos -->
            <section class="checklist-section table-container">
                <div class="section-header flex-between">
                    <h2 class="section-title">Todos os Equipamentos</h2>
                    <div class="filters flex-gap">
                        <input type="text" placeholder="Buscar equipamento..." class="filter-input form-input" id="searchInput">
                        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary">➕ Novo Equipamento</a>
                    </div>
                </div>

                <div class="checklist-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Quantidade Padrão</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($equipamentos)): ?>
                                <?php foreach ($equipamentos as $equipamento): ?>
                                    <tr>
                                        <td><?= $equipamento->id ?></td>
                                        <td><?= h($equipamento->nome) ?></td>
                                        <td><?= $equipamento->quantidade_padrao ?></td>
                                        <td class="actions">
                                            <a href="<?= $this->Url->build(['action' => 'view', $equipamento->id]) ?>" class="btn-action" title="Ver">🔍</a>
                                            <a href="<?= $this->Url->build(['action' => 'edit', $equipamento->id]) ?>" class="btn-action" title="Editar">✏️</a>
                                            <?php if ($isAdmin): ?>
                                            <?= $this->Form->postLink('🗑️', ['action' => 'delete', $equipamento->id], [
                                                'confirm' => 'Tem certeza que deseja excluir este equipamento?',
                                                'class' => 'btn-action',
                                                'escape' => false
                                            ]) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="empty-row">Nenhum equipamento cadastrado</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            const rows = document.querySelectorAll('.checklist-table tbody tr');
            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                row.style.display = name.includes(term) ? '' : 'none';
            });
        });
    }
});
</script>
