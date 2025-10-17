<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Equipamento $equipamento
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Equipamento'), ['action' => 'edit', $equipamento->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Equipamento'), ['action' => 'delete', $equipamento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipamento->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Equipamentos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Equipamento'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="equipamentos view content">
            <h3><?= h($equipamento->nome) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($equipamento->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($equipamento->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantidade Padrao') ?></th>
                    <td><?= $this->Number->format($equipamento->quantidade_padrao) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Maquinas') ?></h4>
                <?php if (!empty($equipamento->maquinas)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Nome') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($equipamento->maquinas as $maquina) : ?>
                        <tr>
                            <td><?= h($maquina->id) ?></td>
                            <td><?= h($maquina->nome) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Maquinas', 'action' => 'view', $maquina->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Maquinas', 'action' => 'edit', $maquina->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Maquinas', 'action' => 'delete', $maquina->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $maquina->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Checklist Equipamentos') ?></h4>
                <?php if (!empty($equipamento->checklist_equipamentos)) : ?>
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
                        <?php foreach ($equipamento->checklist_equipamentos as $checklistEquipamento) : ?>
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