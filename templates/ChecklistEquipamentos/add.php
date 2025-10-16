<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChecklistEquipamento $checklistEquipamento
 * @var \Cake\Collection\CollectionInterface|string[] $checklists
 * @var \Cake\Collection\CollectionInterface|string[] $equipamentos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Checklist Equipamentos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklistEquipamentos form content">
            <?= $this->Form->create($checklistEquipamento) ?>
            <fieldset>
                <legend><?= __('Add Checklist Equipamento') ?></legend>
                <?php
                    echo $this->Form->control('checklist_id', ['options' => $checklists]);
                    echo $this->Form->control('equipamento_id', ['options' => $equipamentos]);
                    echo $this->Form->control('quantidade');
                    echo $this->Form->control('observacao');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
