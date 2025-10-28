<?php
$this->assign('title', 'Login - Sistema de Checklist');
$this->Html->css([
    'variables',
    'reset',
    'layout',
    'forms',
    'buttons',
    'dark-mode',
    'utilities'
], ['block' => true]);
?>
<div class="login-page">
    <div class="login-container">
        <div class="login-logo">
            <img src="<?= $this->Url->image('logo-hiwston.png') ?>" alt="Logo da Empresa">
        </div>
    <div class="users form">
        <?= $this->Flash->render() ?>
        <h3>Login</h3>
        <?= $this->Form->create() ?>
            <?= $this->Form->control('email', ['label' => 'E-mail', 'required' => true]) ?>
            <?= $this->Form->control('password', ['label' => 'Senha', 'required' => true]) ?>
            <?= $this->Form->button(__('Entrar')) ?>
            <?= $this->Form->create(null, ['autocomplete' => 'off']) ?>

        <?= $this->Form->end() ?>
        
        <?php if ($this->request->getParam('action') === 'login' && !$this->request->getData()): ?>
            <div class="login-links" style="margin-top: 20px; text-align: center;">
                <p>Não tem uma conta? <?= $this->Html->link('Cadastre-se aqui', ['action' => 'add']) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>