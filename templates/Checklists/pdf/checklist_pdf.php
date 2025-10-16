<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Checklist</title>
    <style>
        @page {
            margin: 15px;
        }
        body { font-family: sans-serif; font-size: 10px; }
        .container { width: 100%; }
        .header { width: 100%; border-collapse: collapse; }
        .header td { border: 1px solid #000; padding: 2px; }
        .header .logo { width: 20%; text-align: center; }
        .header .title { width: 80%; text-align: center; font-weight: bold; font-size: 14px; }
        .info { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .info td { border: 1px solid #000; padding: 2px; }
        .items { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .items th, .items td { border: 1px solid #000; padding: 2px; text-align: left; }
        .items .check { width: 40px; text-align: center; }
        .footer { width: 100%; margin-top: 10px; }
        .footer td { padding: 5px 0; }

        /* Cores da terceira imagem */
        .header-n-serie { background-color: #c0c0c0; }
        .header-equipamento { background-color: #00b0f0; }
        .header-qtd { background-color: #00b050; }
        .header-conferido { background-color: #92d050; }
        .header-obs { background-color: #ffff00; }
        .equipamento-principal { background-color: #92d050; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <table class="header">
            <tr>
                <td class="logo" rowspan="2">
                    <strong>HIWSTON</strong>
                </td>
                <td class="title" rowspan="2">CHECKLIST VOLUMES EXTERNOS</td>
                <td><strong>Nº ORDEM DE PRODUÇÃO:</strong> <?= h($checklist->numero_ordem_producao) ?></td>
            </tr>
            <tr>
                <td><strong>VOLTAGEM:</strong> <?= h($checklist->voltagem) ?></td>
            </tr>
            <tr>
                <td colspan="2"><strong>CLIENTE:</strong> <?= h($checklist->cliente) ?></td>
                <td><strong>Nº DE SÉRIE:</strong> <?= h($checklist->numero_serie) ?></td>
            </tr>
        </table>

        <table class="info">
            <tr>
                <td><strong>DATA CARREGAMENTO:</strong> <?= h($checklist->data_carregamento ? $checklist->data_carregamento->format('d/m/Y') : '') ?></td>
                <td><strong>HORÁRIO DA SAÍDA:</strong></td>
                <td><strong>SETOR:</strong> D12</td>
            </tr>
            <tr>
                <td colspan="2"><strong>DESTINO:</strong> <?= h($checklist->destino) ?></td>
                <td><strong>EXPEDIÇÃO:</strong></td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th class="header-n-serie">#</th>
                    <th class="header-equipamento">EQUIPAMENTO</th>
                    <th class="header-qtd">QTD</th>
                    <th class="header-conferido">CONFERIDO (OK)</th>
                    <th class="header-obs">OBS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="equipamento-principal"><?= h($checklist->maquina->nome) ?></td>
                    <td>1</td>
                    <td class="check">( )</td>
                    <td></td>
                </tr>
                <?php if (!empty($checklist->checklist_equipamentos)): ?>
                    <?php $i = 2; ?>
                    <?php foreach ($checklist->checklist_equipamentos as $item): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= h($item->equipamento->nome) ?></td>
                        <td><?= h($item->quantidade) ?></td>
                        <td class="check">( )</td>
                        <td><?= h($item->observacao) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: red;">
                            Nenhum equipamento associado a este checklist foi encontrado.
                            Verifique se os equipamentos foram salvos corretamente ao criar o checklist.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <table class="footer">
            <tr>
                <td><strong>ASS. RESP. CONFERÊNCIA:</strong> _________________________________________</td>
            </tr>
            <tr>
                <td><strong>ASS. RESP. EMBARQUE:</strong> _________________________________________</td>
            </tr>
        </table>
    </div>
</body>
</html>