<?php

use Cake\Core\Configure; 
echo $this->Html->script('ckeditor/ckeditor');?>
<?php $this->Html->script(['jquery.validate'], ['block' => 'script']); ?>
<?php $this->Html->script(['craftfood.js'], ['block' => 'script']); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= __('Edit Crafts & Foods') ?></h1>
    <?php $this->Html->addCrumb(__('Crafts & Foods List'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Edit Crafts & Foods'), 'javascript:void(0);', ['class' => 'active']); ?>
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
                <?= $this->Form->create($craftfood, ['id' => 'craftfood', 'class' => 'editcraftfood', 'type' => 'file']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
								<?php  echo $this->Form->input('lang',array('options'=>[''=>'English','hi'=>'Hindi'],'label'=>['text'=>'Select Language'])); ?>
                            </div>
                            <div class="form-group">
                                <?php
                                
                                echo $this->Form->input('craftfood_category', [
                                    'label' => __('Craft & Food Category'),
                                    'options' => array(""=>'Please select category',  1=>'Craft', 2=>'Food'),
                                    'type' => 'select',
                                    'default' => $craftfood->category,
                                    'empty' => __('Please select category'),
                                    'required' => true
                                ]);
 
                                ?>
                            </div>
                            <div class="form-group">
                                <?php echo $this->Form->input('title',['label'=>['text'=>'Title<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <?php echo $this->Form->input('description',['id' => 'description','label'=>['text'=>'Description<span class="red"> * </span>','escape'=>false]]); ?>
                                <script>
                                    var FileManager = '<?=$this->Url->build('/filemanager/');?>';
                                    CKEDITOR.replace('description', {
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
                            <div class="form-group">
                            <?php echo $this->Form->input('short_description',['id' => 'short_description', 'type'=>'textarea', 'label'=>['text'=>'Short Description<span class="red"> * </span>','escape'=>false]]); ?>
							</div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                <?php 
                                if($language == 'hi'){
                                    echo $this->Form->input('address',['label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false]]);     
                                }else{
                                    echo $this->Form->input('address',['label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false],
									//'readonly' => 'readonly'
									]);     
                                }
                                ?>
                                    </div>
                                    <div id="event-image-area">
								<?php 
  
                                if($craftfood->has('craft_food_images')){ ?>
									<?php $i = 0; ?>
									<?php 

                                    foreach($craftfood->craft_food_images as $imgKey => $image){ ?>
                                        <div style="display:none;">
											<?= $this->Form->input('craftfoods_images.'.$imgKey.'.id', ['type' => 'hidden','value' => $image->id]);
											?>
                                        </div>
                                        <div class="form-group" id="field-<?= $imgKey;?>">
											<?= $this->Form->input('craftfoods_images.'.$imgKey.'.image',[
												'label'=>__('Crafts & Foods Image'),
												'type' => 'file',
												'class' => (empty($image['image'])) ? 'image_field' : '',
												'required' => false
												]);
											?>
                                            <div class="form-group uploaded-area">
											<?php 
											if(!empty($image['image'])) {
												echo $this->Form->input('craftfoods_images.'.$imgKey.'.uploaded', ['type' => 'hidden','value' => $image['image']]);
												echo $this->Html->image('../resize/100x100/img/craftfood/'.$image['image']);
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
									<?= $this->Form->input('craftfoods_images.0.image',[
											'label'=>__('Crafts & Foods Image'),
											'type' => 'file',
											'class' => 'image_field'
											]);
										?>
                                        <img src="<?php echo '../../img/craftfood/'.$craftfood->craft_food_images[0]->image; ?>" height="100" width="100">
                                        <div class="form-group" id="field-0">
                                            <div class="form-group remove-area" style="display:none;">
											<?= $this->Form->button(__('Remove'), ['type' => 'button', 'class' => 'btn btn-warning removeimage deleteimage', 'data-removeid' => 0]); ?>
                                            </div>
                                        </div>
								<?php } ?>
                                    </div>
                                    <div class="form-group">
                                <?php echo $this->Form->button(__('Add More'), ['type' => 'button', 'id' => 'addmoreimage', 'class' => 'btn btn-success', 'style' => 'margin-top: 20px;']); ?>
                                    </div>
                                    <div class="form-group">
                                <?php echo $this->Form->input('is_active'); ?>
                                    </div>
									<!--<div class="form-group">
										<?php echo $this->Form->input('sort_order',array('type'=>'select','default' => '0', 'options' => $sort_order)); ?>
									</div>-->
                                </div>
                                <div class="col-md-6">
                                    <div id="myMap"></div><br/>
                                    <div>
								<?= $this->Form->input('latitude', ['type' => 'hidden', 'value' => $craftfood->latitude]) ;?>
								<?= $this->Form->input('longitude', ['type' => 'hidden', 'value' => $craftfood->longitude]) ;?>
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
            window.location.href = '<?php  echo $this->Url->build(["action" => "edit",$craftfood->id,"?" => ["lang" => ""]]); ?>' + $(this).val();
        });
    });

    var deleteimage = "<?php echo $this->Url->build(['controller' => 'CraftFood', 'action' => 'deleteimage']); ?>";

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