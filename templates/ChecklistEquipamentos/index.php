<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ChecklistEquipamento> $checklistEquipamentos
 */
?>
<div class="checklistEquipamentos index content">
    <?= $this->Html->link(__('New Checklist Equipamento'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Checklist Equipamentos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('checklist_id') ?></th>
                    <th><?= $this->Paginator->sort('equipamento_id') ?></th>
                    <th><?= $this->Paginator->sort('quantidade') ?></th>
                    <th><?= $this->Paginator->sort('observacao') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($checklistEquipamentos as $checklistEquipamento): ?>
                <tr>
                    <td><?= $this->Number->format($checklistEquipamento->id) ?></td>
                    <td><?= $checklistEquipamento->hasValue('checklist') ? $this->Html->link($checklistEquipamento->checklist->numero_ordem_producao, ['controller' => 'Checklists', 'action' => 'view', $checklistEquipamento->checklist->id]) : '' ?></td>
                    <td><?= $checklistEquipamento->hasValue('equipamento') ? $this->Html->link($checklistEquipamento->equipamento->nome, ['controller' => 'Equipamentos', 'action' => 'view', $checklistEquipamento->equipamento->id]) : '' ?></td>
                    <td><?= $this->Number->format($checklistEquipamento->quantidade) ?></td>
                    <td><?= h($checklistEquipamento->observacao) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $checklistEquipamento->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $checklistEquipamento->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $checklistEquipamento->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $checklistEquipamento->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>