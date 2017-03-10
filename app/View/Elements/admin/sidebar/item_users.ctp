<li class="<?php if ($this->Menu->isActive('users')) echo 'active'; ?>">
    <a href="<?php echo $this->Html->url(array(
        'controller' => 'users',
        'action'     => 'index',
        'admin'      => true
    )); ?>">
        <i class="entypo-user"></i>
        <span><?php echo __('Usuários'); ?></span>
    </a>
</li>