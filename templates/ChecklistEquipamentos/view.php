<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChecklistEquipamento $checklistEquipamento
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Checklist Equipamento'), ['action' => 'edit', $checklistEquipamento->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Checklist Equipamento'), ['action' => 'delete', $checklistEquipamento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $checklistEquipamento->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Checklist Equipamentos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Checklist Equipamento'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklistEquipamentos view content">
            <h3><?= h($checklistEquipamento->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Checklist') ?></th>
                    <td><?= $checklistEquipamento->hasValue('checklist') ? $this->Html->link($checklistEquipamento->checklist->numero_ordem_producao, ['controller' => 'Checklists', 'action' => 'view', $checklistEquipamento->checklist->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Equipamento') ?></th>
                    <td><?= $checklistEquipamento->hasValue('equipamento') ? $this->Html->link($checklistEquipamento->equipamento->nome, ['controller' => 'Equipamentos', 'action' => 'view', $checklistEquipamento->equipamento->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Observacao') ?></th>
                    <td><?= h($checklistEquipamento->observacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($checklistEquipamento->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantidade') ?></th>
                    <td><?= $this->Number->format($checklistEquipamento->quantidade) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>