<div class="row">

    <div class="col-md-6 col-sm-8 clearfix">

        <ul class="user-info pull-left pull-none-xsm">

            <li class="profile-info dropdown">

                Você está logado como <strong><?php echo $user['email']; ?></strong>

            </li>

        </ul>

    </div>

    <div class="col-md-6 col-sm-4 clearfix hidden-xs">

        <ul class="list-inline links-list pull-right">

            <li>
                <a href="<?php echo $this->Html->url(array(
                    'controller' => 'users',
                    'action'     => 'logout',
                    'admin'      => true
                )); ?>">
                    Sair <i class="entypo-logout right"></i>
                </a>
            </li>

        </ul>

    </div>

</div>

<hr>
