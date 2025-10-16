<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Equipamento $equipamento
 * @var \Cake\Collection\CollectionInterface|string[] $maquinas
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Equipamentos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="equipamentos form content">
            <?= $this->Form->create($equipamento) ?>
            <fieldset>
                <legend><?= __('Add Equipamento') ?></legend>
                <?php
                    echo $this->Form->control('nome');
                    echo $this->Form->control('quantidade_padrao');
                    echo $this->Form->control('maquinas._ids', ['options' => $maquinas]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
