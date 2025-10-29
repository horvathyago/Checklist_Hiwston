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
                    <?= $this->Form->control('numero_ordem_producao', ['label' => 'Número da Ordem de Produção', 'required' => true]) ?>
                    <?= $this->Form->control('cliente', ['label' => 'Cliente', 'required' => true]) ?>
                    <?= $this->Form->control('data_carregamento', ['label' => 'Data de Carregamento', 'empty' => true, 'type' => 'date']) ?>
                    <?= $this->Form->control('destino', ['label' => 'Destino']) ?>
                    <?= $this->Form->control('voltagem', ['label' => 'Voltagem']) ?>
                    <?= $this->Form->control('numero_serie', ['label' => 'Número de Série']) ?>
                    <?= $this->Form->control('maquina_id', [
                        'options' => $maquinas,
                        'empty' => 'Selecione uma máquina',
                        'label' => 'Máquina',
                        'id' => 'maquina-select',
                        'required' => true
                    ]) ?>
                    <hr>
                    <h3>Equipamentos da Máquina</h3>
                    <div class="equipamentos-section">
                        <div id="equipamentos-container" class="equipamentos-list">
                            <p class="no-equipamentos">Selecione uma máquina para ver os equipamentos</p>
                        </div>
                    </div>
                </fieldset>
                <?= $this->Form->button(__('Salvar Checklist'), ['class' => 'btn btn-primary']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </main>
</div>

<!-- CSS adicional (igual ao seu, mantive dark mode) -->
<style>
.equipamentos-section { margin:20px 0; padding:15px; border:1px solid #e0e0e0; border-radius:8px; background:#f9f9f9; }
.equipamentos-list { min-height:50px; }
.equipamento-item { display:flex; align-items:center; padding:12px 15px; margin:8px 0; background:white; border:1px solid #ddd; border-radius:6px; transition:all 0.3s ease; }
.equipamento-item:hover { border-color:#007bff; box-shadow:0 2px 5px rgba(0,123,255,0.1); }
.equipamento-checkbox { margin-right:15px; transform:scale(1.2); cursor:pointer; }
.equipamento-info { flex:1; }
.equipamento-nome { font-weight:600; color:#333; margin-bottom:4px; display:block; cursor:pointer; }
.equipamento-descricao { color:#666; font-size:0.9em; margin-bottom:5px; }
.equipamento-quantidade { display:flex; align-items:center; gap:8px; margin-top:5px; }
.quantidade-label { font-size:0.85em; color:#666; }
.quantidade-input { width:80px; padding:4px 8px; border:1px solid #ddd; border-radius:4px; font-size:0.9em; }
.no-equipamentos, .loading-equipamentos, .error-text { text-align:center; padding:20px; color:#999; font-style:italic; }
.loading-equipamentos { color:#007bff; }
.error-text { color:#dc3545; padding:10px; }
.fade-in { animation:fadeIn 0.5s ease-in; }
@keyframes fadeIn { from {opacity:0; transform:translateY(-10px);} to {opacity:1; transform:translateY(0);} }

/* Dark mode */
.dark-mode .equipamentos-section { background:#2d3748; border-color:#4a5568; }
.dark-mode .equipamento-item { background:#4a5568; border-color:#718096; }
.dark-mode .equipamento-nome { color:#e2e8f0; }
.dark-mode .equipamento-descricao { color:#a0aec0; }
.dark-mode .quantidade-input { background:#2d3748; border-color:#4a5568; color:#e2e8f0; }
</style>

<!-- JS revisado -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const menuToggle = document.getElementById('menuToggle');
    const themeToggle = document.getElementById('themeToggle');
    const maquinaSelect = document.getElementById('maquina-select');
    const equipamentosContainer = document.getElementById('equipamentos-container');

    // ===== Menu Lateral =====
    function toggleSidebar() {
        sidebar.classList.toggle('expanded');
        mainContent.classList.toggle('expanded');
        document.body.classList.toggle('sidebar-open');
        localStorage.setItem('sidebarExpanded', sidebar.classList.contains('expanded'));
    }
    if (localStorage.getItem('sidebarExpanded') === 'true') toggleSidebar();
    menuToggle.addEventListener('click', toggleSidebar);

    // ===== Dark Mode =====
    if (localStorage.getItem('darkMode') === 'true') document.body.classList.add('dark-mode');
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        const dark = document.body.classList.contains('dark-mode');
        themeToggle.textContent = dark ? '☀️' : '🌙';
        localStorage.setItem('darkMode', dark);
    });

    // ===== Carregar Equipamentos =====
    function carregarEquipamentos(maquinaId) {
        if (!maquinaId) {
            equipamentosContainer.innerHTML = '<p class="no-equipamentos">Selecione uma máquina para ver os equipamentos</p>';
            return;
        }
        equipamentosContainer.innerHTML = '<p class="loading-equipamentos">Carregando equipamentos...</p>';
        maquinaSelect.disabled = true;

        const url = '<?= $this->Url->build(['controller' => 'Checklists', 'action' => 'getEquipamentos']) ?>';
        const formData = new FormData();
        formData.append('maquina_id', maquinaId);
        formData.append('_csrfToken', '<?= $this->request->getAttribute('csrfToken') ?>');

        fetch(url, { method: 'POST', body: formData })
        .then(res => res.ok ? res.json() : Promise.reject(`Erro HTTP ${res.status}`))
        .then(data => {
            if (!data || data.length === 0) {
                equipamentosContainer.innerHTML = '<p class="no-equipamentos">Esta máquina não possui equipamentos cadastrados</p>';
                return;
            }
            let html = '';
            data.forEach((equipamento, index) => {
                const quantidadePadrao = (equipamento.quantidade_padrao != null) ? equipamento.quantidade_padrao : 1;
                html += `
                <div class="equipamento-item fade-in">
                    <input type="checkbox" id="equipamento-${index}" name="checklist_equipamentos[${index}][checked]" value="1" checked class="equipamento-checkbox">
                    <input type="hidden" name="checklist_equipamentos[${index}][equipamento_id]" value="${equipamento.id}">
                    <div class="equipamento-info">
                        <label for="equipamento-${index}" class="equipamento-nome">${equipamento.nome}</label>
                        ${equipamento.descricao ? `<div class="equipamento-descricao">${equipamento.descricao}</div>` : ''}
                        <div class="equipamento-quantidade">
                            <span class="quantidade-label">Quantidade:</span>
                            <input type="number" name="checklist_equipamentos[${index}][quantidade]" value="${quantidadePadrao}" min="0" class="quantidade-input">
                        </div>
                    </div>
                </div>`;
            });
            equipamentosContainer.innerHTML = html;
        })
        .catch(err => {
            console.error('Erro ao carregar equipamentos:', err);
            equipamentosContainer.innerHTML = '<p class="error-text">Erro ao carregar equipamentos. Verifique o console.</p>';
        })
        .finally(() => maquinaSelect.disabled = false);
    }

    if (maquinaSelect) {
        maquinaSelect.addEventListener('change', () => carregarEquipamentos(maquinaSelect.value));
        if (maquinaSelect.value) carregarEquipamentos(maquinaSelect.value);
    }
});
</script>
