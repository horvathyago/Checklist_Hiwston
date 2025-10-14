<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Checklist $checklist
 * @var string[]|\Cake\Collection\CollectionInterface $maquinas
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $checklist->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $checklist->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Checklists'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklists form content">
            <?= $this->Form->create($checklist) ?>
            <fieldset>
                <legend><?= __('Edit Checklist') ?></legend>
                <?php
                    echo $this->Form->control('numero_ordem_producao');
                    echo $this->Form->control('cliente');
                    echo $this->Form->control('data_carregamento', ['empty' => true]);
                    echo $this->Form->control('destino');
                    echo $this->Form->control('maquina_id', ['options' => $maquinas]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
