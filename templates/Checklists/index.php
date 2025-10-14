<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Checklist> $checklists
 */
?>
<div class="checklists index content">
    <?= $this->Html->link(__('New Checklist'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Checklists') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('numero_ordem_producao') ?></th>
                    <th><?= $this->Paginator->sort('cliente') ?></th>
                    <th><?= $this->Paginator->sort('data_carregamento') ?></th>
                    <th><?= $this->Paginator->sort('destino') ?></th>
                    <th><?= $this->Paginator->sort('maquina_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($checklists as $checklist): ?>
                <tr>
                    <td><?= $this->Number->format($checklist->id) ?></td>
                    <td><?= h($checklist->numero_ordem_producao) ?></td>
                    <td><?= h($checklist->cliente) ?></td>
                    <td><?= h($checklist->data_carregamento) ?></td>
                    <td><?= h($checklist->destino) ?></td>
                    <td><?= $checklist->hasValue('maquina') ? $this->Html->link($checklist->maquina->nome, ['controller' => 'Maquinas', 'action' => 'view', $checklist->maquina->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $checklist->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $checklist->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $checklist->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $checklist->id),
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