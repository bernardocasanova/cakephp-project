<li class="<?php if ($this->Menu->isActive('groups')) echo 'active'; ?>">
    <a href="<?php echo $this->Html->url(array(
        'controller' => 'groups',
        'action'     => 'index',
        'admin'      => true
    )); ?>">
        <i class="entypo-users"></i>
        <span><?php echo __('Grupos'); ?></span>
    </a>
</li>