<?php $Auth = $this->request->session()->read('Auth.User'); ?>
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php echo $this->Html->image('user-icon.png', array('class' => 'user-image', 'alt' => 'User Image')); ?>
                    <span class="hidden-xs"><?= $Auth['first_name']; ?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <?php echo $this->Html->image('user-icon.png', array('class' => 'img-circle', 'alt' => 'User Image')); ?>

                        <p>
                            <?= $Auth['first_name']; ?>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'myProfile']); ?>"
                                   class="btn btn-link btn-flat"><?= __('Profile'); ?></a>
                            </div>
                            <div class="col-xs-12">
                                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'changePassword']); ?>"
                                   class="btn btn-link btn-flat"><?= __('Change Password'); ?></a>
                            </div>
                        </div>
                        <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-right">
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']); ?>"
                               class="btn btn-default btn-flat"><?= __('Logout'); ?></a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>