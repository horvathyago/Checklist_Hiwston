<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Checklist $checklist
 * @var \Cake\Collection\CollectionInterface|string[] $maquinas
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Checklists'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklists form content">
            <?= $this->Form->create($checklist) ?>
            <fieldset>
                <legend><?= __('Add Checklist') ?></legend>
                <?php
                    echo $this->Form->control('numero_ordem_producao');
                    echo $this->Form->control('cliente');
                    echo $this->Form->control('data_carregamento', ['empty' => true]);
                    echo $this->Form->control('destino');
                    echo $this->Form->control('maquina_id', ['options' => $maquinas, 'empty' => 'Selecione uma máquina']);
                ?>
                <div id="equipamentos-container"></div>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const maquinaSelect = document.getElementById('maquina-id');
    const equipamentosContainer = document.getElementById('equipamentos-container');

    maquinaSelect.addEventListener('change', function() {
        const maquinaId = this.value;
        equipamentosContainer.innerHTML = '';

        if (maquinaId) {
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
                    div.innerHTML = `
                        <label>
                            <input type="checkbox" name="checklist_equipamentos[${index}][equipamento_id]" value="${equipamento.id}" checked>
                            ${equipamento.nome}
                        </label>
                        <input type="number" name="checklist_equipamentos[${index}][quantidade]" value="${equipamento.quantidade_padrao}">
                        <input type="hidden" name="checklist_equipamentos[${index}][id]" value="">
                    `;
                    equipamentosContainer.appendChild(div);
                    index++;
                });
            });
        }
    });
});
</script>