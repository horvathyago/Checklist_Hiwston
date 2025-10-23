<?php
$this->assign('title', 'Adicionar Checklist - Sistema de Checklist');

// CSS utilizados
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

$isAdmin = false;
$currentUser = null;
if ($this->request->getAttribute('identity')) {
    $currentUser = $this->request->getAttribute('identity');
    $isAdmin = ($currentUser->role === 'admin');
}
?>

<div class="app-container">
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="<?= $this->Url->image('logo-hiwston.png') ?>" alt="Logo" class="sidebar-logo">
        </div>

        <div class="sidebar-nav">
            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'index']) ?>" class="sidebar-link <?= $this->request->getParam('action') === 'index' ? 'active' : '' ?>">
                <span class="sidebar-icon">🏠</span><span class="sidebar-text">Dashboard</span>
            </a>

            <?php if ($isAdmin): ?>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="sidebar-link <?= $this->request->getParam('controller') === 'Users' ? 'active' : '' ?>">
                <span class="sidebar-icon">👥</span><span class="sidebar-text">Usuários</span>
            </a>
            <?php endif; ?>

            <a href="<?= $this->Url->build(['controller' => 'Maquinas', 'action' => 'index']) ?>" class="sidebar-link <?= $this->request->getParam('controller') === 'Maquinas' ? 'active' : '' ?>">
                <span class="sidebar-icon">🏭</span><span class="sidebar-text">Máquinas</span>
            </a>

            <a href="<?= $this->Url->build(['controller' => 'Equipamentos', 'action' => 'index']) ?>" class="sidebar-link <?= $this->request->getParam('controller') === 'Equipamentos' ? 'active' : '' ?>">
                <span class="sidebar-icon">🔧</span><span class="sidebar-text">Equipamentos</span>
            </a>

            <a href="<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'add']) ?>" class="sidebar-link <?= $this->request->getParam('action') === 'add' ? 'active' : '' ?>">
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

    <!-- Conteúdo principal -->
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
            <div class="checklists form content">
                <h2 class="section-title">Adicionar Checklist</h2>
                <?= $this->Form->create($checklist) ?>
                <fieldset>
                    <?php
                        echo $this->Form->control('numero_ordem_producao');
                        echo $this->Form->control('cliente');
                        echo $this->Form->control('data_carregamento', ['empty' => true]);
                        echo $this->Form->control('destino');
                        echo $this->Form->control('voltagem');
                        echo $this->Form->control('numero_serie');
                        echo $this->Form->control('maquina_id', ['options' => $maquinas, 'empty' => 'Selecione uma máquina']);
                    ?>
                    <hr>
                    <h3>Equipamentos</h3>
                    <div id="equipamentos-container"></div>
                </fieldset>
                <?= $this->Form->button(__('Salvar Checklist'), ['class' => 'btn btn-primary']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </main>
</div>

<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const menuToggle = document.getElementById('menuToggle');
    const themeToggle = document.getElementById('themeToggle');

    // ===== MENU LATERAL COM ANIMAÇÃO SUAVE =====
    function toggleSidebar() {
        sidebar.classList.toggle('expanded');
        mainContent.classList.toggle('expanded');
        document.body.classList.toggle('sidebar-open');

        const isExpanded = sidebar.classList.contains('expanded');
        localStorage.setItem('sidebarExpanded', isExpanded);
    }

    // Estado salvo no localStorage
    if (localStorage.getItem('sidebarExpanded') === 'true') {
        sidebar.classList.add('expanded');
        mainContent.classList.add('expanded');
        document.body.classList.add('sidebar-open');
    }

    menuToggle.addEventListener('click', toggleSidebar);

    // ===== MODO ESCURO =====
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        themeToggle.textContent = '☀️';
    }

    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        const dark = document.body.classList.contains('dark-mode');
        themeToggle.textContent = dark ? '☀️' : '🌙';
        localStorage.setItem('darkMode', dark);
    });

    // ===== CARREGAR EQUIPAMENTOS DINAMICAMENTE =====
    const maquinaSelect = document.getElementById('maquina-id');
    const equipamentosContainer = document.getElementById('equipamentos-container');

    if (maquinaSelect) {
        maquinaSelect.addEventListener('change', function() {
            const maquinaId = this.value;
            equipamentosContainer.innerHTML = '';
            if (!maquinaId) return;

            fetch('<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'getEquipamentos']) ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>'
                },
                body: 'maquina_id=' + maquinaId
            })
            .then(response => response.json())
            .then(data => {
                let index = 0;
                data.forEach(equipamento => {
                    const div = document.createElement('div');
                    div.className = 'equipamento-item fade-in';

                    div.innerHTML = `
                        <input type="hidden" name="checklist_equipamentos[${index}][equipamento_id]" value="${equipamento.id}">
                        <div class="equipamento-line">
                            <input type="checkbox" id="eq-${index}" name="checklist_equipamentos[${index}][checked]" value="1" checked>
                            <label for="eq-${index}" class="equipamento-nome">${equipamento.nome}</label>
                            <label class="equipamento-qtde-label">Quantidade:</label>
                            <input type="number" name="checklist_equipamentos[${index}][quantidade]" value="${equipamento.quantidade_padrao || 1}" min="0" class="equipamento-qtde">
                        </div>`;
                    equipamentosContainer.appendChild(div);
                    index++;
                });
            })
            .catch(err => {
                console.error('Erro ao carregar equipamentos:', err);
                equipamentosContainer.innerHTML = '<p class="error-text">Erro ao carregar equipamentos.</p>';
            });
        });
    }
});
</script>
