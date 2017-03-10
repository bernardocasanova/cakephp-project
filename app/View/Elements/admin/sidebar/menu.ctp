<div class="sidebar-menu">

    <div class="sidebar-menu-inner">

        <header class="logo-env">

            <!-- logo -->
            <div class="logo">
                <?php

                echo $this->Html->link(
                    $this->Html->image('/admin/images/logo-radios-3.png', array(
                        'width'  => '140',
                        'height' => '35'
                    )),
                    '/',
                    array('escape' => false)
                );

                ?>
            </div>

            <!-- logo collapse icon -->
            <div class="sidebar-collapse">
                <a href="#" class="sidebar-collapse-icon with-animation">
                    <i class="entypo-menu"></i>
                </a>
            </div>

            <!-- open/close menu icon -->
            <div class="sidebar-mobile-menu visible-xs">
                <a href="#" class="with-animation">
                    <i class="entypo-menu"></i>
                </a>
            </div>

        </header>

        <ul id="main-menu" class="main-menu auto-inherit-active-class">
            <!-- add class "multiple-expanded" to allow multiple submenus to open -->

            <?php echo $this->element('admin/sidebar/item_users'); ?>

            <?php echo $this->element('admin/sidebar/item_groups'); ?>

            <?php echo $this->element('admin/sidebar/item_radios'); ?>

        </ul>

    </div>

</div>
