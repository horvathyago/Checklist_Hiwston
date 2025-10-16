<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Equipamento> $equipamentos
 */
?>
<div class="equipamentos index content">
    <?= $this->Html->link(__('New Equipamento'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Equipamentos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('quantidade_padrao') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipamentos as $equipamento): ?>
                <tr>
                    <td><?= $this->Number->format($equipamento->id) ?></td>
                    <td><?= h($equipamento->nome) ?></td>
                    <td><?= $this->Number->format($equipamento->quantidade_padrao) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $equipamento->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $equipamento->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $equipamento->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $equipamento->id),
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