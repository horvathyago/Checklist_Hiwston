<?php
$this->assign('title', 'Dashboard - Sistema de Checklist');
$this->Html->css('home', ['block' => true]);
?>

<div class="app-container">
    <!-- Sidebar -->
    <nav class="sidebar collapsed" id="sidebar">
        <div class="sidebar-header">
            <img src="<?= $this->Url->image('logo-hiwston.png') ?>" alt="Logo" class="sidebar-logo">
        </div>

        <div class="sidebar-nav">
            <a href="#" class="sidebar-link active">
                <span class="sidebar-icon">🏠</span><span class="sidebar-text">Dashboard</span>
            </a>
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon">🏭</span><span class="sidebar-text">Máquinas</span>
            </a>
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon">🔧</span><span class="sidebar-text">Equipamentos</span>
            </a>
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon">➕</span><span class="sidebar-text">Novo Checklist</span>
            </a>
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
                <span class="current-time"><?= date('d/m/Y - H:i') ?></span>
            </div>
        </header>

        <div class="dashboard-main">
            <!-- Cards -->
            <section class="stats-section">
                <h2 class="section-title">Resumo Geral</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">🏭</div>
                        <div class="stat-info">
                            <span class="stat-number">0</span>
                            <span class="stat-label">Máquinas</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">🔧</div>
                        <div class="stat-info">
                            <span class="stat-number">0</span>
                            <span class="stat-label">Equipamentos</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📋</div>
                        <div class="stat-info">
                            <span class="stat-number">0</span>
                            <span class="stat-label">Checklists</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tabela -->
            <section class="checklist-section">
                <div class="section-header">
                    <h2 class="section-title">Todos os Checklists</h2>
                    <div class="filters">
                        <input type="text" placeholder="Buscar por nome..." class="filter-input">
                        <input type="date" class="filter-input">
                        <button class="filter-btn">Buscar</button>
                    </div>
                </div>

                <div class="checklist-table">
                    <table>
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
                            <tr>
                                <td colspan="5" class="empty-row">Nenhum checklist encontrado</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const mainContent = document.getElementById('mainContent');
    const themeToggle = document.getElementById('themeToggle');
    const timeEl = document.querySelector('.current-time');

    // Menu lateral animado
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    });

    // Atualizar hora em tempo real
    function updateTime() {
        const now = new Date();
        timeEl.textContent = now.toLocaleDateString('pt-BR') + ' - ' + now.toLocaleTimeString('pt-BR');
    }
    setInterval(updateTime, 1000);

    // Dark mode
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        themeToggle.textContent = document.body.classList.contains('dark-mode') ? '☀️' : '🌙';
    });
});
</script>
