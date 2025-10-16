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
                    echo $this->Form->control('voltagem');
                    echo $this->Form->control('numero_serie');
                    echo $this->Form->control('maquina_id', ['options' => $maquinas, 'empty' => 'Selecione uma máquina']);
                ?>
                <hr>
                <h3>Equipamentos</h3>
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

                    // Hidden input for the equipment ID
                    const hiddenEquipamentoId = document.createElement('input');
                    hiddenEquipamentoId.type = 'hidden';
                    hiddenEquipamentoId.name = `checklist_equipamentos[${index}][equipamento_id]`;
                    hiddenEquipamentoId.value = equipamento.id;

                    // Checkbox for selection
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = `checklist_equipamentos[${index}][_joinData][checked]`;
                    checkbox.value = 1;
                    checkbox.checked = true;
                    checkbox.id = `checklist_equipamentos-${index}-checked`;

                    const label = document.createElement('label');
                    label.htmlFor = checkbox.id;
                    label.appendChild(document.createTextNode(equipamento.nome));

                    // Input for the quantity
                    const quantidadeInput = document.createElement('input');
                    quantidadeInput.type = 'number';
                    quantidadeInput.name = `checklist_equipamentos[${index}][_joinData][quantidade]`;
                    quantidadeInput.value = equipamento.quantidade_padrao;

                    // Hidden input for the ChecklistEquipamento ID (empty for new records)
                    const hiddenId = document.createElement('input');
                    hiddenId.type = 'hidden';
                    hiddenId.name = `checklist_equipamentos[${index}][id]`;
                    hiddenId.value = '';

                    div.appendChild(hiddenEquipamentoId);
                    div.appendChild(checkbox);
                    div.appendChild(label);
                    div.appendChild(quantidadeInput);
                    div.appendChild(hiddenId);
                    equipamentosContainer.appendChild(div);
                    index++;
                });
            });
        }
    });
});
</script>