<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Ações') ?></h4>

            <?php
                $currentUser = $this->Identity->get('role') ?? null;
                if ($currentUser === 'admin'):
            ?>
                <?= $this->Html->link(__('Editar Usuário'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Form->postLink(
                    __('Excluir Usuário'),
                    ['action' => 'delete', $user->id],
                    [
                        'confirm' => __('Tem certeza que deseja excluir o usuário #{0}?', $user->id),
                        'class' => 'side-nav-item text-danger'
                    ]
                ) ?>
            <?php endif; ?>

            <?= $this->Html->link(__('Listar Usuários'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>

            <?php if ($currentUser === 'admin'): ?>
                <?= $this->Html->link(__('Novo Usuário'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            <?php endif; ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="users view content">
            <h3><?= h($user->name) ?></h3>

            <table class="table table-striped">
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($user->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('E-mail') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo de Usuário') ?></th>
                    <td>
                        <?php if ($user->role === 'admin'): ?>
                            <span style="color: #c0392b; font-weight: bold;">Administrador</span>
                        <?php else: ?>
                            <span style="color: #2980b9;">Usuário Comum</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Criado em') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Última Modificação') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
