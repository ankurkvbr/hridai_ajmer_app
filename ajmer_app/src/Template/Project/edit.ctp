<?php

echo $this->Html->script('ckeditor/ckeditor');?>
<?php $this->Html->script(['jquery.validate'], ['block' => 'script']); ?>
<?php $this->Html->script(['project.js'], ['block' => 'script']); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= __('Edit Project') ?></h1>
    <?php $this->Html->addCrumb(__('Event List'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Edit Project'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?=
    $this->Html->getCrumbList(
            ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false], ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    );
    ?>
</section>
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-xs-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <?= $this->Form->create($project, ['id' => 'project', 'class' => 'editProject', 'type' => 'file']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
								<?php  echo $this->Form->input('lang',array('options'=>[''=>'English','hi'=>'Hindi'],'label'=>['text'=>'Select Language'])); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $this->Form->input('project_name',['label'=>['text'=>'Project Name<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <?php echo $this->Form->input('project_description',['id' => 'project_description','label'=>['text'=>'Project Description<span class="red"> * </span>','escape'=>false]]); ?>
                                <script>
                                    var FileManager = '<?=$this->Url->build('/filemanager/');?>';
                                    CKEDITOR.replace('project_description', {
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
                                        filebrowserImageBrowseUrl: FileManager + 'index.html?type=image',
                                        filebrowserImageUploadUrl: FileManager + 'custom-upload.php?action=QuickUpload',
                                        uploadUrl: FileManager + 'custom-upload.php'
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-md-11">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                <?php 
                                if($language == 'hi'){
                                    echo $this->Form->input('address', [
                                    'label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false],
									'empty' => __('Please enter Address'),
									'required' => true,
									]);                                     
                                }else{
                                    echo $this->Form->input('address', [
                                    'label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false],
									//'readonly' => 'readonly',
									'empty' => __('Please enter Address'),
									'required' => true,
									]); 
                                }
                                ?>
                                    </div>
                                    <!--<div class="form-group">
                                <?php
                                echo $this->Form->input('state_id', [
                                   'label'=>['text'=>'State<span class="red"> * </span>','escape'=>false],
                                    'options' => $states,
                                    'type' => 'select',
                                    'empty' => __('Please select State'),
                                    'required' => true
                                ]);
                                ?>
                                    </div>
                                    <div class="form-group">
                                <?php
                                echo $this->Form->input('city_id', [
                                    'label'=>['text'=>'City<span class="red"> * </span>','escape'=>false],
                                    'options' => $cities,
                                    'type' => 'select',
                                    'value' => isset($project->cities_id) ? $project->cities_id : '',
                                    'empty' => __('Please select city'),
                                    'required' => true
                                ]);
                                ?>
                                    </div>-->
                                    <div class="form-group">
                                <?php echo $this->Form->input('is_active'); ?>
                                    </div>
                                    <!--<div class="form-group">
                                <?php echo $this->Form->input('url',[
									'label'=>['text'=>'URL','escape'=>false],
									'type' => 'url',
									'empty' => __('Please Enter URL'),
									'required' => false
								]); ?>
                                    </div>-->
                                    <div id="event-image-area">
								<?php 
  
                                                                if($project->has('project_images')){ ?>
									<?php $i = 0; ?>
									<?php 

                                                                        foreach($project->project_images as $imgKey => $image){ ?>
                                        <div style="display:none;">
											<?= $this->Form->input('project_images.'.$imgKey.'.id', ['type' => 'hidden','value' => $image->id]);
											?>
                                        </div>
                                        <div class="form-group" id="field-<?= $imgKey;?>">
											<?= $this->Form->input('project_images.'.$imgKey.'.image',[
												'label'=>__('Project Image'),
												'type' => 'file',
												'class' => (empty($image['image'])) ? 'image_field' : '',
												'required' => false
												]);
											?>
                                            <div class="form-group uploaded-area">
											<?php 
											if(!empty($image['image'])) {
												echo $this->Form->input('project_images.'.$imgKey.'.uploaded', ['type' => 'hidden','value' => $image['image']]);
												echo $this->Html->image('../resize/100x100/img/project/'.$image['image']);
											}
											?>
                                            </div>
											<?php 
                                                                                        //if($i != 0){ ?>
                                            <div class="form-group remove-area">
													<?= $this->Form->button(__('Remove'), ['type' => 'button', 'class' => 'btn btn-warning deleteimage', 'data-removeid' => $imgKey, 'id' => $image->id]); ?>
                                            </div>
											<?php //} 
												//$i++;
											?>
                                        </div>
									<?php } ?>
								<?php } else { 
                                                                    ?>
									<?= $this->Form->input('project_images.0.image',[
											'label'=>__('Project Image 1'),
											'type' => 'file',
											'class' => 'image_field'
											]);
										?>
									<?php //echo $this->Html->image('../resize/100x100/img/monumentsgardens/'.$monumentsgardens->monuments_gardens_images[0]->image); ?>
                                        <img src="<?php echo '../../img/project/'.$project->project_images[0]->image; ?>" height="100" width="100">
                                        <div class="form-group" id="field-0">
                                            <div class="form-group remove-area" style="display:none;">
											<?= $this->Form->button(__('Remove'), ['type' => 'button', 'class' => 'btn btn-warning removeimage deleteimage', 'data-removeid' => 0]); ?>
                                            </div>
                                        </div>
								<?php } ?>

                                    </div>
                                <?php //} ?>
                                    <div class="form-group">
                                <?php echo $this->Form->button(__('Add More'), ['type' => 'button', 'id' => 'addmoreimage', 'class' => 'btn btn-success', 'style' => 'margin-top: 20px;']); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="myMap"></div><br/>
                                    <div>
								<?= $this->Form->input('latitude', ['type' => 'hidden', 'value' => $project->latitude]) ;?>
								<?= $this->Form->input('longitude', ['type' => 'hidden', 'value' => $project->longitude]) ;?>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                                <?= $this->Form->button(__('Submit')) ?>
                                <?php  echo $this->Html->link('<div class="btn btn-success">Cancel</div>', ['action' => 'index'], ['class' => 'btn btn-sm text-success', 'escape' => false, 'title'=>'Cancel']) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>
<?php $this->start('scriptBotton'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        //Add / Edit
        $("#lang").change(function () {
            window.location.href = '<?php  echo $this->Url->build(["action" => "edit",$project->id,"?" => ["lang" => ""]]); ?>' + $(this).val();
        });
    });
    var deleteimage = "<?php echo $this->Url->build(['controller' => 'Project', 'action' => 'deleteimage']); ?>";
</script>
<?php $this->end('scriptBotton'); ?>
<style>
    #myMap {
        height: 350px;
        width: 350px;
    }
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBemfQhlJ1Tv9uOb5mIjMoMhztkR9CI5NM&sensor=false"></script>
<?php 

if($language != 'hi'){
$this->Html->script(['eventMap.js'],['block' => 'script']); }?>
