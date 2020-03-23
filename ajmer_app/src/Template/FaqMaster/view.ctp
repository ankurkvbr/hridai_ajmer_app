<?php
/**
  * @var \App\View\AppView $this
  */
?>
<section class="content-header">
    <?php if($this->request->params['action'] == 'myProfile'){ ?>
        <h1><?php  echo __('My Profile') ?></h1>
        <?php //$this->Html->addCrumb(__('User Management'), ['action' => 'index']); ?>
        <?php $this->Html->addCrumb(__('My Profile'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php }else{ ?>
        <h1><?php  echo __('FAQ :')  ?></h1>
        <?php $this->Html->addCrumb(__('FAQ List'), ['action' => 'index']); ?>
        <?php $this->Html->addCrumb(__('FAQ'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php } ?>
    <?php  echo $this->Html->getCrumbList(
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
                                    <th scope="row"><strong><?php  echo __('Id :') ?></strong></th>
                                    <td><?php  echo $this->Number->format($faqMaster->id) ?></td>
                                </tr>
							</div>
							<div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?php  echo __('Title :') ?></strong></th>
                                    <td><?php  echo h($faqMaster->faq_title) ?></td>
                                </tr>
							</div>
							<div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?php  echo __('Description :') ?></strong></th>
                                    <td><?php  echo h($faqMaster->faq_description) ?></td>
                                </tr>
							</div>
							<div class="form-group">
							<tr>
                                <th scope="row"><strong><?php  echo __('Created Date :') ?></strong></th>
                                <td><?php  echo h($faqMaster->created_at) ?></td>
                            </tr>
							</div>
							<div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?php  echo __('Updated Date :') ?></strong></th>
                                    <td><?php  echo h($faqMaster->updated_at) ?></td>
                                </tr>
                            </div>
							<div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?php  echo __('Is Active :') ?></strong></th>
                                    <td><?php  echo $faqMaster->is_active ? __('Yes') : __('No'); ?></td>
                                </tr>
                            </div>
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