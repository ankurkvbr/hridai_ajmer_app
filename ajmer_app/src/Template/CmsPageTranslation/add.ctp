<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php $this->Html->script(['jquery.validate'],['block' => 'script']); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= __('Add Cms Page Translation') ?></h1>
    <?php $this->Html->addCrumb(__('User Management'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Create User'), 'javascript:void(0);', ['class' => 'active']); ?>
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
               
                <?= $this->Form->create($cmsPageTranslation,['id' => 'cmsfrm']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $this->Form->input('name'); ?>
                            </div>
							<div class="form-group">
                                <?= $this->Form->input('description'); ?>
								
                            </div>
                            <div class="form-group">
                                <?= $this->Form->input('meta_title'); ?>
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('meta_keywords'); ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->input('meta_description'); ?>
								
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('lang'); ?>
                            </div>
							 <div class="form-group">
                                 <?= $this->Form->input('is_active', ['options' => ['1' => __('Active'), '0' => __('Inactive')],'type' => 'checkbox',['label'=>'Status*']]); ?>
                            </div>
							 
                        </div>
                    </div>
                </div>
                
                <div class="box-footer">
                    <?= $this->Form->button(__('Submit')) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
    </div>
    <!-- /.row -->
</section>

<?php $this->start('scriptBotton'); ?>
<script> 
	 $(document).ready(function () {
		
		$("#cmsfrm").validate({
			rules: {
				'name':{required: true},
				'description': {required: true},
				'meta_title': {required: true},
				'meta_keywords': {required: true},
				'meta_description': {required: true},
				'lang': {required: true},
				'is_active': {required: true}
				
			},
			messages: {
				'name':{required: 'Please Enter Name'},
				'description': {required: 'Please Enter Description'},
				'meta_title': {required: 'Please Enter Meta Title'},
				'meta_keywords': {required: 'Please Enter Meta Keywords'},
				'meta_description': {required: 'Please Enter Meta Description'},
				'lang': {required: 'Please Enter Language code'},
				'is_active': {required: 'Please Select Is Active'}
				
			},
		});
		
	
		
	});
</script>
<?php $this->end('scriptBotton'); ?>






<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Cms Page Translation'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cms Page'), ['controller' => 'CmsPage', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cms Page'), ['controller' => 'CmsPage', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cmsPageTranslation form large-9 medium-8 columns content">
    <?= $this->Form->create($cmsPageTranslation) ?>
    <fieldset>
        <legend><?= __('Add Cms Page Translation') ?></legend>
        <?php
            //echo $this->Form->input('cms_page_id', ['options' => $cmsPage]);
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            echo $this->Form->input('meta_title');
            echo $this->Form->input('meta_keywords');
            echo $this->Form->input('meta_description');
            echo $this->Form->input('lang');
			echo $this->Form->input('is_active', ['options' => ['1' => __('Active'), '0' => __('Inactive')],'type' => 'checkbox',['label'=>'Status*']]);
            //echo $this->Form->input('created_by');
            //echo $this->Form->input('created_at');
           // echo $this->Form->input('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>-->
