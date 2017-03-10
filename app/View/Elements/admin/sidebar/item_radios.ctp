<li class="<?php if ($this->Menu->isActive('radios')) echo 'active'; ?>">
    <a href="<?php echo $this->Html->url(array(
        'controller' => 'radios',
        'action'     => 'index',
        'admin'      => true
    )); ?>">
        <i class="entypo-note-beamed"></i>
        <span><?php echo __('Rádios'); ?></span>
    </a>
</li>