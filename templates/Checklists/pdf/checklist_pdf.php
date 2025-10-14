<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Checklist</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .container { width: 100%; }
        .header { width: 100%; border-collapse: collapse; }
        .header td { border: 1px solid #000; padding: 5px; }
        .header .logo { width: 20%; text-align: center; }
        .header .title { width: 80%; text-align: center; font-weight: bold; font-size: 16px; }
        .info { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .info td { border: 1px solid #000; padding: 5px; }
        .items { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .items th, .items td { border: 1px solid #000; padding: 5px; text-align: left; }
        .items .check { width: 40px; text-align: center; }
        .footer { width: 100%; margin-top: 20px; }
        .footer td { padding: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <table class="header">
            <tr>
                <td class="logo">
                    <!-- Você pode colocar o logo da Hiwston aqui -->
                    <strong>HIWSTON</strong>
                </td>
                <td class="title">CHECKLIST VOLUMES EXTERNOS</td>
            </tr>
        </table>

        <table class="info">
            <tr>
                <td><strong>Nº ORDEM DE PRODUÇÃO:</strong> <?= h($checklist->numero_ordem_producao) ?></td>
                <td><strong>DATA CARREGAMENTO:</strong> <?= h($checklist->data_carregamento ? $checklist->data_carregamento->format('d/m/Y') : '') ?></td>
                <td><strong>SETOR:</strong> </td>
            </tr>
            <tr>
                <td><strong>CLIENTE:</strong> <?= h($checklist->cliente) ?></td>
                <td><strong>HORÁRIO DA SAÍDA:</strong></td>
                <td><strong>EXPEDIÇÃO:</strong></td>
            </tr>
            <tr>
                <td colspan="3"><strong>DESTINO:</strong> <?= h($checklist->destino) ?></td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>EQUIPAMENTO</th>
                    <th>QTD</th>
                    <th class="check">CONFERIDO ( )</th>
                    <th>OBS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" style="background-color: #e0e0e0; font-weight: bold;"><?= h($checklist->maquina->nome) ?></td>
                </tr>
                <?php foreach ($checklist->checklist_equipamentos as $item): ?>
                <tr>
                    <td><?= h($item->equipamento->nome) ?></td>
                    <td><?= h($item->quantidade) ?></td>
                    <td class="check">( )</td>
                    <td><?= h($item->observacao) ?></td>
                </tr>
                <?php endforeach; ?>
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