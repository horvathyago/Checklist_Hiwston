<div class="users form">
    <?= $this->Flash->render() ?>
    <h3>Login</h3>
    <?= $this->Form->create() ?>
        <?= $this->Form->control('email', ['label' => 'E-mail', 'required' => true]) ?>
        <?= $this->Form->control('password', ['label' => 'Senha', 'required' => true]) ?>
        <?= $this->Form->button(__('Entrar')) ?>
    <?= $this->Form->end() ?>
    
    <?php if ($this->request->getParam('action') === 'login' && !$this->request->getData()): ?>
        <div class="login-links" style="margin-top: 20px; text-align: center;">
            <p>Não tem uma conta? <?= $this->Html->link('Cadastre-se aqui', ['action' => 'add']) ?></p>
        </div>
    <?php endif; ?>
</div>