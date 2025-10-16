<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Maquina $maquina
 * @var \Cake\Collection\CollectionInterface|string[] $equipamentos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Maquinas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="maquinas form content">
            <?= $this->Form->create($maquina) ?>
            <fieldset>
                <legend><?= __('Add Maquina') ?></legend>
                <?php
                    echo $this->Form->control('nome');
                    echo $this->Form->control('equipamentos._ids', ['options' => $equipamentos]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
