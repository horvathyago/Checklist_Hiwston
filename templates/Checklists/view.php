<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Checklist $checklist
 */
?>
<div class="checklist-view">
    <h2>Checklist #<?= h($checklist->id) ?> - <?= h($checklist->cliente) ?></h2>
    <table class="table">
        <tr><th>Numero Ordem Produção</th><td><?= h($checklist->numero_ordem_producao) ?></td></tr>
        <tr><th>Cliente</th><td><?= h($checklist->cliente) ?></td></tr>
        <tr><th>Destino</th><td><?= h($checklist->destino) ?></td></tr>
        <tr><th>Máquina</th><td><?= $checklist->maquina->nome ?? '-' ?></td></tr>
        <tr><th>Data Carregamento</th><td><?= h($checklist->data_carregamento) ?></td></tr>
    </table>

    <h4>Equipamentos</h4>
    <?php if (!empty($checklist->checklist_equipamentos)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Equipamento ID</th>
                <th>Quantidade</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($checklist->checklist_equipamentos as $item): ?>
                <tr>
                    <td><?= h($item->equipamento_id) ?></td>
                    <td><?= h($item->quantidade) ?></td>
                    <td><?= h($item->observacao) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Nenhum equipamento relacionado.</p>
    <?php endif; ?>
</div>
