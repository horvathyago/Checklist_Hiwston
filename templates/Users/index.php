<?php
$this->assign('title', 'Usuários - Sistema de Checklist');
$this->Html->css([
    'variables', 'reset', 'layout', 'sidebar', 'header', 'buttons',
    'cards', 'tables', 'forms', 'dark-mode', 'utilities', 'professional',
    'modal' // CSS do modal
], ['block' => true]);

$this->Html->script(['dashboard','modal'], ['block' => true]);

$currentUser = $currentUser ?? $this->request->getAttribute('identity');
$isAdmin = $currentUser && $currentUser->role === 'admin';
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
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="sidebar-link active admin-only">
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

            <div class="sidebar-logout">
                <?= $this->Form->postLink(
                    '<span class="sidebar-icon">🚪</span><span class="sidebar-text">Sair</span>',
                    ['controller' => 'Users', 'action' => 'logout'],
                    ['escape' => false, 'class' => 'sidebar-link logout-link', 'confirm' => 'Tem certeza que deseja sair?']
                ) ?>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="main-content" id="mainContent">
        <header class="dashboard-header">
            <button class="menu-toggle" id="menuToggle">☰</button>
            <div class="header-center">
                <img src="<?= $this->Url->image('logo-hiwston.png') ?>" alt="Logo da Empresa" class="header-logo">
            </div>
            <div class="header-right">
                <button id="themeToggle" class="theme-toggle" title="Alternar tema">🌙</button>
                <span class="current-time"><?= date('d/m/Y H:i') ?></span>
                <?php if ($currentUser): ?>
                    <div class="user-info">
                        <span class="user-name"><?= h($currentUser->username ?? $currentUser->email) ?></span>
                        <span class="user-role"><?= $isAdmin ? '👑 Admin' : '👤 Usuário' ?></span>
                        <?= $this->Form->postLink('🚪 Sair', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn-logout', 'confirm' => 'Tem certeza que deseja sair?']) ?>
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
                     <?php if ($isAdmin && isset($usersCount)): ?>
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

            <!-- Tabela de Usuários -->
            <section class="checklist-section table-container">
                <div class="section-header flex-between">
                    <h2 class="section-title">Todos os Usuários</h2>
                    <div class="filters flex-gap">
                        <input type="text" placeholder="Buscar usuário..." class="filter-input form-input" id="searchInput">
                        <button class="btn btn-primary" id="btnAddUser">➕ Novo Usuário</button>
                    </div>
                </div>

                <div class="checklist-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Perfil</th>
                                <th>Criado em</th>
                                <th>Modificado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user->id ?></td>
                                    <td><?= h($user->name) ?></td>
                                    <td><?= h($user->email) ?></td>
                                    <td><span class="role-badge role-<?= h($user->role) ?>"><?= h($user->role) ?></span></td>
                                    <td><?= $user->created->format('d/m/Y H:i') ?></td>
                                    <td><?= $user->modified->format('d/m/Y H:i') ?></td>
                                    <td class="actions">
                                        <a href="<?= $this->Url->build(['action'=>'view',$user->id]) ?>" class="btn-view btn-action">👁️</a>
                                        <a href="<?= $this->Url->build(['action'=>'edit',$user->id]) ?>" class="btn-edit btn-action">✏️</a>
                                        <?= $this->Form->postLink('🗑️', ['action'=>'delete',$user->id], ['confirm'=>'Tem certeza que deseja excluir este usuário?', 'class'=>'btn-delete btn-action', 'escape'=>false]) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="empty-row">Nenhum usuário cadastrado</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</div>

<!-- MODAL DE NOVO USUÁRIO -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeUserModal">&times;</span>
        <div id="userModalBody"></div> <!-- começa vazio -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Busca
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

    // --- MODAL USUÁRIO ---
    const btnUser = document.getElementById('btnAddUser');
    const modalUser = document.getElementById('userModal');
    const closeModalUser = document.getElementById('closeUserModal');
    const modalBodyUser = document.getElementById('userModalBody');

    if (btnUser && modalUser) {
        btnUser.addEventListener('click', function(e) {
            e.preventDefault();
            modalUser.style.display = 'flex';
            modalBodyUser.innerHTML = '<p class="loading">Carregando formulário...</p>';

            fetch("<?= $this->Url->build(['action'=>'add']) ?>")
                .then(res => res.text())
                .then(html => {
                    modalBodyUser.innerHTML = html;
                    const aside = modalBodyUser.querySelector('aside.column');
                    if (aside) aside.remove();
                })
                .catch(() => {
                    modalBodyUser.innerHTML = '<p style="color:red; text-align:center;">Erro ao carregar formulário.</p>';
                });
        });

        closeModalUser.addEventListener('click', () => modalUser.style.display = 'none');
        window.addEventListener('click', e => { if (e.target === modalUser) modalUser.style.display = 'none'; });
    }
});
</script>
