<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Checklist $checklist
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Checklist'), ['action' => 'edit', $checklist->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Checklist'), ['action' => 'delete', $checklist->id], ['confirm' => __('Are you sure you want to delete # {0}?', $checklist->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Checklists'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Checklist'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Gerar PDF'), ['action' => 'generatePdf', $checklist->id], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklists view content">
            <h3><?= h($checklist->numero_ordem_producao) ?></h3>
            <table>
                <tr>
                    <th><?= __('Numero Ordem Producao') ?></th>
                    <td><?= h($checklist->numero_ordem_producao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cliente') ?></th>
                    <td><?= h($checklist->cliente) ?></td>
                </tr>
                <tr>
                    <th><?= __('Destino') ?></th>
                    <td><?= h($checklist->destino) ?></td>
                </tr>
                <tr>
                    <th><?= __('Maquina') ?></th>
                    <td><?= $checklist->hasValue('maquina') ? $this->Html->link($checklist->maquina->nome, ['controller' => 'Maquinas', 'action' => 'view', $checklist->maquina->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($checklist->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Carregamento') ?></th>
                    <td><?= h($checklist->data_carregamento) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Checklist Equipamentos') ?></h4>
                <?php if (!empty($checklist->checklist_equipamentos)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Checklist Id') ?></th>
                            <th><?= __('Equipamento Id') ?></th>
                            <th><?= __('Quantidade') ?></th>
                            <th><?= __('Observacao') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($checklist->checklist_equipamentos as $checklistEquipamento) : ?>
                        <tr>
                            <td><?= h($checklistEquipamento->id) ?></td>
                            <td><?= h($checklistEquipamento->checklist_id) ?></td>
                            <td><?= h($checklistEquipamento->equipamento_id) ?></td>
                            <td><?= h($checklistEquipamento->quantidade) ?></td>
                            <td><?= h($checklistEquipamento->observacao) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ChecklistEquipamentos', 'action' => 'view', $checklistEquipamento->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ChecklistEquipamentos', 'action' => 'edit', $checklistEquipamento->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ChecklistEquipamentos', 'action' => 'delete', $checklistEquipamento->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $checklistEquipamento->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>