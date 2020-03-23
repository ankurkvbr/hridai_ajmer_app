<?php echo $this->Html->script('ckeditor/ckeditor');?>
<?php $this->Html->script(['cmsValidation'],['block' => 'script']); ?>
<?php $this->Html->script(['jquery.validate'],['block' => 'script']); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php  echo __('Edit CMS Page') ?></h1>
    <?php $this->Html->addCrumb(__('CMS Page List'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Edit CMS Page'), 'javascript:void(0);', ['class' => 'active']); ?>
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
               
                <?php  echo $this->Form->create($cmsPage,['id' => 'cmsfrm']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
						<div class="form-group">
								<?php  echo $this->Form->input('lang',array('options'=>[''=>'English','hi'=>'Hindi'],'label'=>['text'=>'Select Language'])); ?>
                            </div>
                            <div class="form-group">
                                <?php  echo $this->Form->input('name',['label'=>['text'=>'Name<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
							</div>
							<div class="col-md-10">
							<div class="form-group">
                                <?php  echo $this->Form->input('description',array('type'=>'textarea','id' => 'description','label'=>['text'=>'Description<span class="red"> * </span>','escape'=>false])); ?>
                            <script>
						var FileManager = '<?=$this->Url->build('/filemanager/');?>';
						CKEDITOR.replace( 'description',{
							allowedContent: {
								script: false,
								div: true,
								$1: {
									elements: CKEDITOR.dtd,
									attributes: true,
									styles: true,
									classes: true
								}
							},
							customConfig: 'custom/template-other-config.js',
							extraPlugins: 'uploadimage,uploadwidget,customFields',
							filebrowserImageBrowseUrl : FileManager + 'index.html?type=image',
							filebrowserImageUploadUrl : FileManager + 'custom-upload.php?action=QuickUpload',
							uploadUrl : FileManager + 'custom-upload.php'
						});
					</script>
							</div>
							</div>
							<div class="col-md-6">
                            <div class="form-group">
                                <?php  echo $this->Form->input('meta_title'); ?>
                            </div>
							 <div class="form-group">
                                <?php  echo $this->Form->input('meta_keywords'); ?>
                            </div>
                            <div class="form-group">
                                <?php  echo $this->Form->input('meta_description',array('type'=>'textarea')); ?>
                            </div>
							                
                            <div class="form-group">
                                <?php  echo $this->Form->input('is_active', ['options' => ['1' => __('Active'), '0' => __('Inactive')],'type' => 'checkbox',['label'=>'Status*']]); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php  echo $this->Form->button(__('Submit')) ?>
					<?php  echo $this->Html->link('<div class="btn btn-success">cancel</div>', ['action' => 'index'], ['class' => 'btn btn-sm text-success', 'escape' => false, 'title'=>'cancel']) ?>
                </div>
                <?php  echo $this->Form->end() ?>
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
		//Add / Edit
		$("#lang").change(function(){
			window.location.href = '<?php  echo $this->Url->build(["action" => "edit",base64_encode($cmsPage->id),"?" => ["lang" => ""]]); ?>'+$(this).val();
		});
	});
</script>
<?php $this->end('scriptBotton'); ?>
