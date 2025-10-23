/**
 * Dashboard - Sistema de Checklist
 * JavaScript para funcionalidades do dashboard
 * Transições ultra suaves e animações profissionais
 */

class Dashboard {
    constructor() {
        this.sidebar = document.getElementById('sidebar');
        this.menuToggle = document.getElementById('menuToggle');
        this.mainContent = document.getElementById('mainContent');
        this.themeToggle = document.getElementById('themeToggle');
        this.timeEl = document.querySelector('.current-time');
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.updateDate();
        this.startDateUpdater();
        this.setupPerformanceOptimizations();
    }

    setupEventListeners() {
        // Menu lateral com transição suave
        this.menuToggle.addEventListener('click', () => this.toggleSidebar());
        
        // Dark mode com transição suave
        this.themeToggle.addEventListener('click', () => this.toggleTheme());
        
        // Efeitos hover suaves para cards
        this.setupCardHoverEffects();
        
        // Efeitos hover suaves para tabela
        this.setupTableHoverEffects();
        
        // Filtros com interações suaves
        this.setupFilterInteractions();
    }

    toggleSidebar() {
        // Aplica transições ultra suaves
        this.sidebar.style.transition = 'width var(--transition-ultra-smooth), box-shadow var(--transition-smooth)';
        this.mainContent.style.transition = 'all var(--transition-ultra-smooth)';
        
        // Animação do botão menu
        this.animateMenuToggle();
        
        // Toggle classes
        this.sidebar.classList.toggle('collapsed');
        this.mainContent.classList.toggle('expanded');
        
        // Atualiza layout após transição
        setTimeout(() => this.updateLayout(), 400);
    }

    animateMenuToggle() {
        this.menuToggle.style.transition = 'all var(--transition-bouncy)';
        this.menuToggle.style.transform = 'rotate(90deg) scale(1.1)';
        
        setTimeout(() => {
            this.menuToggle.style.transform = 'rotate(0deg) scale(1)';
        }, 300);
    }

    toggleTheme() {
        // Aplica transição suave para todo o body
        document.body.style.transition = 'background var(--transition-ultra-smooth), color var(--transition-ultra-smooth)';
        
        // Animação do botão theme
        this.animateThemeToggle();
        
        // Toggle dark mode
        document.body.classList.toggle('dark-mode');
        
        // Atualiza ícone com transição suave
        setTimeout(() => {
            const isDarkMode = document.body.classList.contains('dark-mode');
            this.themeToggle.textContent = isDarkMode ? '☀️' : '🌙';
            this.themeToggle.style.transform = 'scale(1) rotate(0deg)';
            
            // Salva preferência
            this.saveThemePreference(isDarkMode);
        }, 200);
    }

    animateThemeToggle() {
        this.themeToggle.style.transition = 'all var(--transition-bouncy)';
        this.themeToggle.style.transform = 'scale(1.3) rotate(180deg)';
    }

    saveThemePreference(isDarkMode) {
        try {
            localStorage.setItem('darkMode', isDarkMode);
        } catch (e) {
            console.warn('Não foi possível salvar a preferência de tema:', e);
        }
    }

    loadThemePreference() {
        try {
            const darkMode = localStorage.getItem('darkMode') === 'true';
            if (darkMode) {
                document.body.classList.add('dark-mode');
                this.themeToggle.textContent = '☀️';
            }
        } catch (e) {
            console.warn('Não foi possível carregar a preferência de tema:', e);
        }
    }

    updateDate() {
        const now = new Date();
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = now.getFullYear();
        
        // Transição suave do texto
        this.timeEl.style.transition = 'opacity var(--transition-micro)';
        this.timeEl.style.opacity = '0';
        
        setTimeout(() => {
            this.timeEl.textContent = `${day}/${month}/${year}`;
            this.timeEl.style.opacity = '1';
        }, 150);
    }

    startDateUpdater() {
        // Atualiza a cada minuto (caso mude o dia)
        setInterval(() => this.updateDate(), 60000);
    }

    setupCardHoverEffects() {
        const statCards = document.querySelectorAll('.stat-card-link');
        
        statCards.forEach(card => {
            card.addEventListener('mouseenter', (e) => {
                const statCard = e.currentTarget.querySelector('.stat-card');
                const statIcon = e.currentTarget.querySelector('.stat-icon');
                
                if (statCard && statIcon) {
                    statCard.style.transition = 'all var(--transition-bouncy)';
                    statIcon.style.transition = 'all var(--transition-bouncy)';
                }
            });
            
            card.addEventListener('touchstart', (e) => {
                e.currentTarget.classList.add('touch-hover');
            });
            
            card.addEventListener('touchend', (e) => {
                setTimeout(() => {
                    e.currentTarget.classList.remove('touch-hover');
                }, 300);
            });
        });
    }

    setupTableHoverEffects() {
        const tableRows = document.querySelectorAll('.table tbody tr');
        
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', (e) => {
                e.currentTarget.style.transition = 'all var(--transition-smooth)';
            });
        });
    }

    setupFilterInteractions() {
        const filterInputs = document.querySelectorAll('.filter-input');
        const filterBtn = document.querySelector('.filter-btn');
        
        filterInputs.forEach(input => {
            input.addEventListener('focus', (e) => {
                e.target.style.transition = 'all var(--transition-smooth)';
                e.target.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', (e) => {
                e.target.style.transform = 'scale(1)';
            });
        });
        
        if (filterBtn) {
            filterBtn.addEventListener('click', (e) => {
                e.target.style.transition = 'all var(--transition-bouncy)';
                e.target.style.transform = 'scale(0.95)';
                
                setTimeout(() => {
                    e.target.style.transform = 'scale(1)';
                }, 150);
            });
        }
    }

    updateLayout() {
        // Força reflow para otimizar renderização
        this.mainContent.offsetHeight;
    }

    setupPerformanceOptimizations() {
        // Preload transitions para melhor performance
        setTimeout(() => {
            document.body.style.willChange = 'auto';
        }, 1000);
        
        // Carrega preferência de tema
        this.loadThemePreference();
        
        // Otimiza animações para dispositivos com reduz-motion
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.style.setProperty('--transition-ultra-smooth', '0.1s ease');
            document.documentElement.style.setProperty('--transition-smooth', '0.1s ease');
            document.documentElement.style.setProperty('--transition-bouncy', '0.1s ease');
            document.documentElement.style.setProperty('--transition-micro', '0.05s ease');
        }
    }

    // Método para atualizar dados em tempo real (pode ser expandido)
    updateStats(data) {
        if (data.maquinas !== undefined) {
            const maquinasEl = document.querySelector('.stat-card-link:nth-child(1) .stat-number');
            if (maquinasEl) this.animateNumberChange(maquinasEl, data.maquinas);
        }
        
        if (data.equipamentos !== undefined) {
            const equipamentosEl = document.querySelector('.stat-card-link:nth-child(2) .stat-number');
            if (equipamentosEl) this.animateNumberChange(equipamentosEl, data.equipamentos);
        }
        
        if (data.checklists !== undefined) {
            const checklistsEl = document.querySelector('.stat-card-link:nth-child(3) .stat-number');
            if (checklistsEl) this.animateNumberChange(checklistsEl, data.checklists);
        }
    }

    animateNumberChange(element, newValue) {
        element.style.transition = 'all var(--transition-smooth)';
        element.style.transform = 'scale(1.1)';
        element.style.color = 'var(--primary)';
        
        setTimeout(() => {
            element.textContent = newValue;
            element.style.transform = 'scale(1)';
            element.style.color = '';
        }, 300);
    }
}

// Inicialização quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa o dashboard
    window.dashboard = new Dashboard();
    
    // Adiciona classe loaded para animações de entrada
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 100);
});

// Handle errors gracefully
window.addEventListener('error', function(e) {
    console.error('Erro no dashboard:', e.error);
});
