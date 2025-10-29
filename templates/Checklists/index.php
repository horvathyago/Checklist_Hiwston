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
            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'index']) ?>" class="sidebar-link active">
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
                    <?= $this->Form->postLink('🚪 Sair', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn-logout', 'confirm' => 'Tem certeza que deseja sair?']) ?>
                </div>
                <?php endif; ?>
            </div>
        </header>

        <div class="dashboard-main content-wrapper">
            <!-- Tabela Checklists -->
            <section class="checklist-section table-container">
                <div class="section-header flex-between">
                    <h2 class="section-title">Todos os Checklists</h2>
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
                                        <td><?= $checklist->data instanceof \Cake\I18n\Time ? $checklist->data->format('d/m/Y') : date('d/m/Y', strtotime($checklist->data)) ?></td>
                                        <td><span class="status-badge status-<?= strtolower($checklist->status) ?>"><?= h($checklist->status) ?></span></td>
                                        <td class="actions">
                                            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'view', $checklist->id]) ?>" 
                                               class="btn-view btn-action" title="Visualizar"
                                               data-checklist-id="<?= $checklist->id ?>">👁️</a>
                                            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'edit', $checklist->id]) ?>" 
                                               class="btn-edit btn-action" title="Editar"
                                               data-checklist-id="<?= $checklist->id ?>">✏️</a>
                                            <?php if ($isAdmin): ?>
                                            <?= $this->Form->postLink('🗑️', ['controller' => 'Checklists', 'action' => 'delete', $checklist->id], ['confirm' => 'Tem certeza que deseja excluir este checklist?', 'class' => 'btn-delete btn-action', 'title' => 'Excluir', 'escape' => false]) ?>
                                            <?= $this->Html->link('📄 PDF', ['controller' => 'Checklists', 'action' => 'generatePdf', $checklist->id], ['class' => 'btn-action', 'target' => '_blank', 'title' => 'Gerar PDF']) ?>
                                            <?php else: ?>
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

<!-- MODAL DE VISUALIZAÇÃO -->
<div id="checklistModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Visualizar Checklist</h3>
            <span class="close-btn" id="closeChecklistModal">&times;</span>
        </div>
        <div id="checklistModalBody" class="modal-body">
            <p class="loading">Carregando informações...</p>
        </div>
    </div>
</div>

<!-- MODAL DE EDIÇÃO -->
<div id="editChecklistModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Editar Checklist</h3>
            <span class="close-btn" id="closeEditChecklistModal">&times;</span>
        </div>
        <div id="editChecklistModalBody" class="modal-body">
            <p class="loading">Carregando formulário...</p>
        </div>
    </div>
</div>

<!-- JS para modais -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Visualizar
    const modal = document.getElementById("checklistModal");
    const modalBody = document.getElementById("checklistModalBody");
    const closeBtn = document.getElementById("closeChecklistModal");

    document.querySelectorAll(".btn-view").forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            const url = btn.getAttribute("href");
            modal.style.display = "flex";
            modalBody.innerHTML = "<p class='loading'>Carregando informações...</p>";
            fetch(url)
                .then(response => response.text())
                .then(html => modalBody.innerHTML = html)
                .catch(() => modalBody.innerHTML = "<p class='error'>Erro ao carregar o checklist.</p>");
        });
    });

    closeBtn.addEventListener("click", () => modal.style.display = "none");
    modal.addEventListener("click", e => { if(e.target === modal) modal.style.display = "none"; });

    // Editar
    const editModal = document.getElementById("editChecklistModal");
    const editModalBody = document.getElementById("editChecklistModalBody");
    const closeEditBtn = document.getElementById("closeEditChecklistModal");

    document.querySelectorAll(".btn-edit").forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            const url = btn.getAttribute("href");
            editModal.style.display = "flex";
            editModalBody.innerHTML = "<p class='loading'>Carregando formulário...</p>";
            fetch(url)
                .then(response => response.text())
                .then(html => editModalBody.innerHTML = html)
                .catch(() => editModalBody.innerHTML = "<p class='error'>Erro ao carregar o formulário.</p>");
        });
    });

    closeEditBtn.addEventListener("click", () => editModal.style.display = "none");
    editModal.addEventListener("click", e => { if(e.target === editModal) editModal.style.display = "none"; });
});
</script>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
    overflow: auto;
}

.modal-content {
    background: #fff;
    color: #000;
    padding: 20px;
    border-radius: 10px;
    width: 85%;
    max-width: 900px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    background: #fff;
    padding-bottom: 10px;
    border-bottom: 1px solid #ccc;
    z-index: 10;
}

.modal-body {
    padding-top: 10px;
    overflow-y: auto;
}

.close-btn {
    cursor: pointer;
    font-size: 24px;
}

.loading { font-style: italic; }
.error { color: red; }
</style>
