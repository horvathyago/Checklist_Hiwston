document.addEventListener('DOMContentLoaded', function() {

  function initModal(btnId, modalId, closeId, modalBodyId) {
    const btn = document.getElementById(btnId);
    const modal = document.getElementById(modalId);
    const closeBtn = document.getElementById(closeId);
    const modalBody = document.getElementById(modalBodyId);

    if (!btn || !modal) return;

    modal.style.display = 'none'; // garante que o modal está fechado

    btn.addEventListener('click', function(e) {
      e.preventDefault();
      modal.style.display = 'flex';
      modalBody.innerHTML = '<p class="loading">Carregando formulário...</p>';

      fetch(this.getAttribute('href'))
        .then(res => res.text())
        .then(html => {
          modalBody.innerHTML = html;

          // Remove sidebar lateral do formulário
          const aside = modalBody.querySelector('aside.column');
          if (aside) aside.remove();

          // Ajusta o form carregado
          const form = modalBody.querySelector('form');
          if (form) {
            form.style.width = '98%';
            form.style.maxWidth = '98%';
            form.style.margin = '0 auto';
            form.style.boxSizing = 'border-box';
          }
        })
        .catch(() => {
          modalBody.innerHTML = '<p style="color:red; text-align:center;">Erro ao carregar formulário.</p>';
        });
    });

    // Fechar modal com botão X
    closeBtn.addEventListener('click', () => modal.style.display = 'none');

    // Fechar modal clicando fora da modal-content
    window.addEventListener('click', e => {
      if (e.target === modal) modal.style.display = 'none';
    });
  }

  // Inicializa os modais
  initModal('btnAddEquipamento', 'equipamentoModal', 'closeModal', 'modalBody');
  initModal('btnAddMaquina', 'maquinaModal', 'closeMaquinaModal', 'maquinaModalBody');

});
