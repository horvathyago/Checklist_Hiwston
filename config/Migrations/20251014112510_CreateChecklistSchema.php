<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateChecklistSchema extends AbstractMigration
{
    public function change(): void
    {
        // Tabela de Maquinas
        $this->table('maquinas')
            ->addColumn('nome', 'string', ['limit' => 255])
            ->create();

        // Tabela de Equipamentos
        $this->table('equipamentos')
            ->addColumn('nome', 'string', ['limit' => 255])
            ->addColumn('quantidade_padrao', 'integer')
            ->create();

        // Tabela de associação Maquinas <-> Equipamentos
        $this->table('maquinas_equipamentos')
            ->addColumn('maquina_id', 'integer')
            ->addColumn('equipamento_id', 'integer')
            ->addForeignKey('maquina_id', 'maquinas', 'id')
            ->addForeignKey('equipamento_id', 'equipamentos', 'id')
            ->create();

        // Tabela de Checklists
        $this->table('checklists')
            ->addColumn('numero_ordem_producao', 'string', ['limit' => 255])
            ->addColumn('cliente', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('data_carregamento', 'date', ['null' => true])
            ->addColumn('destino', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('maquina_id', 'integer')
            ->addForeignKey('maquina_id', 'maquinas', 'id')
            ->create();

        // Tabela de Equipamentos do Checklist
        $this->table('checklist_equipamentos')
            ->addColumn('checklist_id', 'integer')
            ->addColumn('equipamento_id', 'integer')
            ->addColumn('quantidade', 'integer')
            ->addColumn('observacao', 'string', ['limit' => 255, 'null' => true])
            ->addForeignKey('checklist_id', 'checklists', 'id')
            ->addForeignKey('equipamento_id', 'equipamentos', 'id')
            ->create();
    }
}