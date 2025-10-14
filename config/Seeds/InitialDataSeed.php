<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class InitialDataSeed extends AbstractSeed
{
    public function run(): void
    {
        // Limpar tabelas para evitar duplicação
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->table('maquinas_equipamentos')->truncate();
        $this->table('equipamentos')->truncate();
        $this->table('maquinas')->truncate();
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');

        // Maquinas
        $maquinasData = [
            ['id' => 1, 'nome' => 'VIBRO PRENSA AUTOMÁTICA DE BLOCO HTX 900'],
            ['id' => 2, 'nome' => 'ESTEIRA EXTRATORA HTXE 900'],
            ['id' => 3, 'nome' => 'ESTEIRA TRANSPORTADORA HET 5500'],
            ['id' => 4, 'nome' => 'MISTURADOR HMO 1000P'],
            ['id' => 5, 'nome' => 'ROBÔ PALETIZADOR HRP 900'],
        ];
        $maquinas = $this->table('maquinas');
        $maquinas->insert($maquinasData)->save();

        // Equipamentos
        $equipamentosData = [
            // HTX 900 (IDs 1-11)
            ['id' => 1, 'nome' => 'CORPO DA FORMA', 'quantidade_padrao' => 4],
            ['id' => 2, 'nome' => 'PARAFUSO DO COPO', 'quantidade_padrao' => 4],
            ['id' => 3, 'nome' => 'PARAFUSO DO PRENSADOR', 'quantidade_padrao' => 4],
            ['id' => 4, 'nome' => 'MOLAS DO SAIOTE', 'quantidade_padrao' => 8],
            ['id' => 5, 'nome' => 'PÉS (BASE E BORRACHAS)', 'quantidade_padrao' => 4],
            ['id' => 6, 'nome' => 'CHAPA SENSOR DO CARRINHO', 'quantidade_padrao' => 1],
            ['id' => 7, 'nome' => 'ARRUELAS CNC', 'quantidade_padrao' => 10],
            ['id' => 8, 'nome' => 'TANQUE', 'quantidade_padrao' => 1],
            ['id' => 9, 'nome' => 'RADIADOR', 'quantidade_padrao' => 1],
            ['id' => 10, 'nome' => 'BOMBA 1CV - 02 VÁLVULAS', 'quantidade_padrao' => 3],
            ['id' => 11, 'nome' => 'PAINÉIS C/ TRANSISTOR (13 UNIDADES)', 'quantidade_padrao' => 1],
            // HTXE 900 (IDs 12-14)
            ['id' => 12, 'nome' => 'PÉS E BASE', 'quantidade_padrao' => 4],
            ['id' => 13, 'nome' => 'GUIA DA TÁBUA', 'quantidade_padrao' => 2],
            ['id' => 14, 'nome' => 'BATEDOR DA TÁBUA', 'quantidade_padrao' => 2],
            // HET 5500 (IDs 15-20)
            ['id' => 15, 'nome' => 'ESCOVA ROTATIVA', 'quantidade_padrao' => 1],
            ['id' => 16, 'nome' => 'PÉ H (PEQUENO)', 'quantidade_padrao' => 2],
            ['id' => 17, 'nome' => 'SAIA DA ESTEIRA (CUBA GRANDE)', 'quantidade_padrao' => 2],
            ['id' => 18, 'nome' => 'PÉ H (GRANDE)', 'quantidade_padrao' => 2],
            ['id' => 19, 'nome' => 'TRAVA DO PÉ', 'quantidade_padrao' => 4],
            ['id' => 20, 'nome' => 'LONA COM RASTRO', 'quantidade_padrao' => 2],
            // HMO 1000P (IDs 21-22)
            ['id' => 21, 'nome' => 'PAINEL DO MISTURADOR', 'quantidade_padrao' => 1],
            ['id' => 22, 'nome' => 'KIT DE BRAÇOS, RASPADOR E LÂMINAS', 'quantidade_padrao' => 1],
            // HRP 900 (ID 23)
            ['id' => 23, 'nome' => 'BASE SENSOR PALLET', 'quantidade_padrao' => 1],
            // Itens Gerais (IDs 24-30)
            ['id' => 24, 'nome' => 'VÁLVULA REGULADORA DE VAZÃO', 'quantidade_padrao' => 1],
            ['id' => 25, 'nome' => 'FLANGE SILOTOP', 'quantidade_padrao' => 1],
            ['id' => 26, 'nome' => 'SILOTOP', 'quantidade_padrao' => 1],
            ['id' => 27, 'nome' => 'PAINEL', 'quantidade_padrao' => 1],
            ['id' => 28, 'nome' => 'SISTEMA DOSADOR DE ÁGUA E ADITIVO', 'quantidade_padrao' => 1],
            ['id' => 29, 'nome' => 'VÍDEO DE MARKETING', 'quantidade_padrao' => 0],
            ['id' => 30, 'nome' => 'LIMPEZA DOS EQUIPAMENTOS', 'quantidade_padrao' => 0],
        ];
        $equipamentos = $this->table('equipamentos');
        $equipamentos->insert($equipamentosData)->save();

        // Associação Maquinas <-> Equipamentos
        $maquinasEquipamentosData = [
            // HTX 900
            ...array_map(fn($id) => ['maquina_id' => 1, 'equipamento_id' => $id], range(1, 11)),
            // HTXE 900
            ...array_map(fn($id) => ['maquina_id' => 2, 'equipamento_id' => $id], range(12, 14)),
            // HET 5500
            ...array_map(fn($id) => ['maquina_id' => 3, 'equipamento_id' => $id], range(15, 20)),
            // HMO 1000P
            ...array_map(fn($id) => ['maquina_id' => 4, 'equipamento_id' => $id], range(21, 22)),
            // HRP 900
            ['maquina_id' => 5, 'equipamento_id' => 23],
            // Itens Gerais (associados a todas as máquinas)
            ...array_map(fn($id) => ['maquina_id' => 1, 'equipamento_id' => $id], range(24, 30)),
            ...array_map(fn($id) => ['maquina_id' => 2, 'equipamento_id' => $id], range(24, 30)),
            ...array_map(fn($id) => ['maquina_id' => 3, 'equipamento_id' => $id], range(24, 30)),
            ...array_map(fn($id) => ['maquina_id' => 4, 'equipamento_id' => $id], range(24, 30)),
            ...array_map(fn($id) => ['maquina_id' => 5, 'equipamento_id' => $id], range(24, 30)),
        ];
        $maquinasEquipamentos = $this->table('maquinas_equipamentos');
        $maquinasEquipamentos->insert($maquinasEquipamentosData)->save();
    }
}