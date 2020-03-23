<?php $this->Html->script(['jquery.validate'],['block' => 'script']); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= __('Change Password') ?></h1>
    <?php $this->Html->addCrumb(__('User Management'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Change Password'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?= $this->Html->getCrumbList(
        ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false],
        ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    ); ?>
</section>
<!-- Main content -->

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-xs-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- <div class="box-header with-border">-->
                <!--<h3 class="box-title">Create Department</h3>-->
                <!--</div>-->
                <!-- /.box-header -->
                <!-- form start -->
                <?= $this->Form->create($user,['id' => 'ChangPassFrm']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
							
                            <div class="form-group">
                                <?= $this->Form->input('current_password',['type'=>'password','label'=>'Old Password']); ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->input('password',['type'=>'password','label'=>'New Password']); ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->input('confirm_password',['type'=>'password']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?= $this->Form->button(__('Change Password')) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
    </div>
    <!-- /.row -->
</section>
<!--/.content-->
<!--<style src="/damei/trunk/source/css/style.css"></style> -->
<?php $this->start('scriptBotton'); ?>

<script>
	$(document).ready(function () {
		//Add / Edit
		$("#ChangPassFrm").validate({
			rules: {
				
				"current_password": {required: true},
				"password": {required: true},
				"confirm_password": {required: true}
			},
			messages: {
				
				"current_password": {required: "Please Enter Current Password"},
				"password": {required: "Please Enter Password"},
				"confirm_password": {required: "Please Enter Confirm Password"},
			},
		});
	});
</script>
<?php $this->end('scriptBotton'); ?>