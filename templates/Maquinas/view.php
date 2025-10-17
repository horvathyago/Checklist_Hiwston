<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Maquina $maquina
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Maquina'), ['action' => 'edit', $maquina->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Maquina'), ['action' => 'delete', $maquina->id], ['confirm' => __('Are you sure you want to delete # {0}?', $maquina->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Maquinas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Maquina'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="maquinas view content">
            <h3><?= h($maquina->nome) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($maquina->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($maquina->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Equipamentos') ?></h4>
                <?php if (!empty($maquina->equipamentos)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Nome') ?></th>
                            <th><?= __('Quantidade Padrao') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($maquina->equipamentos as $equipamento) : ?>
                        <tr>
                            <td><?= h($equipamento->id) ?></td>
                            <td><?= h($equipamento->nome) ?></td>
                            <td><?= h($equipamento->quantidade_padrao) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Equipamentos', 'action' => 'view', $equipamento->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Equipamentos', 'action' => 'edit', $equipamento->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Equipamentos', 'action' => 'delete', $equipamento->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $equipamento->id),
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
                <h4><?= __('Related Checklists') ?></h4>
                <?php if (!empty($maquina->checklists)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Numero Ordem Producao') ?></th>
                            <th><?= __('Cliente') ?></th>
                            <th><?= __('Data Carregamento') ?></th>
                            <th><?= __('Destino') ?></th>
                            <th><?= __('Maquina Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($maquina->checklists as $checklist) : ?>
                        <tr>
                            <td><?= h($checklist->id) ?></td>
                            <td><?= h($checklist->numero_ordem_producao) ?></td>
                            <td><?= h($checklist->cliente) ?></td>
                            <td><?= h($checklist->data_carregamento) ?></td>
                            <td><?= h($checklist->destino) ?></td>
                            <td><?= h($checklist->maquina_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Checklists', 'action' => 'view', $checklist->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Checklists', 'action' => 'edit', $checklist->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Checklists', 'action' => 'delete', $checklist->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $checklist->id),
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