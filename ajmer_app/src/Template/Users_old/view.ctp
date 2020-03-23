<?php
/**
  * @var \App\View\AppView $this
  */
?>
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
    </ul>
</nav>-->
<section class="content-header">
    <?php if($this->request->params['action'] == 'myProfile'){ ?>
        <h1><?= __('My Profile') ?></h1>
        <?php //$this->Html->addCrumb(__('User Management'), ['action' => 'index']); ?>
        <?php $this->Html->addCrumb(__('My Profile'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php }else{ ?>
        <h1><?= __('User:').' '.h($user->name)  ?></h1>
        <?php $this->Html->addCrumb(__('User Management'), ['action' => 'index']); ?>
        <?php $this->Html->addCrumb(__('User Profile'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php } ?>
    <?= $this->Html->getCrumbList(
        ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false],
        ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    ); ?>
</section>
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-xs-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?= __('First Name') ?></strong></th>
                                    <td><?= h($user->first_name) ?></td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?= __('Last Name') ?></strong></th>
                                    <td><?= h($user->last_name) ?></td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?= __('Email') ?></strong></th>
                                    <td><?= h($user->email) ?></td>
                                </tr>
                            </div>
                            <?php /*<div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?= __('Role') ?></strong></th>
                                    <td><?= $user->role->name ?></td>
                                </tr>
                            </div>*/ ?>
                            <div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?= __('Status') ?></strong></th>
                                    <td><?= ($this->Number->format($user->status)) ? 'Active':'Inactive' ?></td>
                                </tr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
    </div>
    <!-- /.row -->
</section>
<!--/.content-->
<!--
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($user->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($user->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= h($user->state) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= h($user->city) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Device Type') ?></th>
            <td><?= h($user->device_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile No') ?></th>
            <td><?= $this->Number->format($user->mobile_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Postal Code') ?></th>
            <td><?= $this->Number->format($user->postal_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role Id') ?></th>
            <td><?= $this->Number->format($user->role_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated By') ?></th>
            <td><?= $this->Number->format($user->updated_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($user->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dob') ?></th>
            <td><?= h($user->dob) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registration Date') ?></th>
            <td><?= h($user->registration_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated Date') ?></th>
            <td><?= h($user->updated_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fp Token At') ?></th>
            <td><?= h($user->fp_token_at) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($user->address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Device Token') ?></h4>
        <?= $this->Text->autoParagraph(h($user->device_token)); ?>
    </div>
    <div class="row">
        <h4><?= __('Fp Token') ?></h4>
        <?= $this->Text->autoParagraph(h($user->fp_token)); ?>
    </div>
</div>-->
