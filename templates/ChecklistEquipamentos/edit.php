<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChecklistEquipamento $checklistEquipamento
 * @var string[]|\Cake\Collection\CollectionInterface $checklists
 * @var string[]|\Cake\Collection\CollectionInterface $equipamentos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $checklistEquipamento->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $checklistEquipamento->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Checklist Equipamentos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklistEquipamentos form content">
            <?= $this->Form->create($checklistEquipamento) ?>
            <fieldset>
                <legend><?= __('Edit Checklist Equipamento') ?></legend>
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
