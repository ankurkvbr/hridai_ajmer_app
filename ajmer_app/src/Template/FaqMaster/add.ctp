<?php echo $this->Html->script('ckeditor/ckeditor');?>
<?php $this->Html->script(['FAQErrorValidations'],['block' => 'script']); ?>
<?php $this->Html->script(['jquery.validate'],['block' => 'script']); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php  echo __('Add FAQ') ?></h1>
    <?php $this->Html->addCrumb(__('FAQ List'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Add FAQ'), 'javascript:void(0);', ['class' => 'active']); ?>
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
              <?php  echo $this->Form->create($faqMaster,['id' => 'FaqBtn']) ?>
				<div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
							<div class="form-group">
								<?php  echo $this->Form->input('faq_title',['autocomplete' => 'off','label'=>['text'=>'Question<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
							 <div class="form-group">
								<?php  echo $this->Form->input('faq_description',['autocomplete' => 'off','class' => 'ckeditor','label'=>['text'=>'Answer<span class="red"> * </span>','escape'=>false]],array('type'=>'textarea')); ?>
                            </div>
							<div class="form-group">
							<?php  echo $this->Form->input('is_active',array('type'=>'checkbox','default' => true) ,['options' => ['1' => __('Active'), '0' => __('Inactive')]]); ?>
							</div>
						</div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php  echo $this->Form->button(__('Submit')) ?>
					<?php  echo $this->Html->link('<div class="btn btn-success">Cancel</div>', ['action' => 'index'], ['class' => 'btn btn-sm text-success', 'escape' => false, 'title'=>'Cancel']) ?>
                   
                </div>
                <?php  echo $this->Form->end() ?>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
    </div>
    <!-- /.row -->
</section>

