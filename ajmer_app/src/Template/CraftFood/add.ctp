<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php echo $this->Html->script('ckeditor/ckeditor');?>
<?php $this->Html->script(['jquery.validate'], ['block' => 'script']); ?>
<?php $this->Html->script(['craftfood.js'], ['block' => 'script']); ?>

<section class="content-header">
    <h1><?php echo __('Add Crafts & Foods') ?></h1>
    <?php $this->Html->addCrumb(__('Crafts-Foods List'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Add Crafts-Foods'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php echo
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
                <?php echo $this->Form->create($craftfood, ['id' => 'craftfood', 'type' => 'file']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                
                                echo $this->Form->input('craftfood_category', [
                                    'label' => __('Craftfood Category'),
                                    'options' => array(""=>'Please select category',  1=>'Craft', 2=>'Food'),
                                    'type' => 'select',
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
							<?php echo $this->Form->input('description',array('type'=>'textarea','id' => 'description','label'=>['text'=>'Description<span class="red"> * </span>','escape'=>false])); ?>
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
                                    echo $this->Form->input('address',['label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false],
									//'readonly' => 'readonly'
									]);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php echo $this->Form->input('is_active',array('type'=>'checkbox','default' => true) ,['options' => ['1' => __('Active'), '0' => __('Inactive')]]); ?>
                            </div>
							<!--<div class="form-group">
                                <?php echo $this->Form->input('sort_order',array('type'=>'select','default' => '0', 'options' => $sort_order)); ?>
                            </div>-->
                            <div id="event-image-area">
                                <?php if ($craftfood->has('craftfoods_images')) { ?>
                                    <?php foreach ($craftfood->craftfoods_images as $imgKey => $image) { ?>
                                        <div class="form-group" id="field-<?php echo $imgKey; ?>">
                                            <?php echo
                                            $this->Form->input('craftfoods_images.' . $imgKey . '.image', [
                                                'label' => __('Crafts & Foods Image'),
                                                'type' => 'file',
                                                'class' => 'image_field'
                                            ]);
                                            ?>
                                            <div class="form-group remove-area" style="display:none;">
                                                <?php echo $this->Form->button(__('Remove'), ['type' => 'button', 'class' => 'btn btn-warning removeimage', 'data-removeid' => $imgKey]); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="form-group" id="field-0">
                                        <?php echo
                                        $this->Form->input('craftfoods_images.0.image', [
                                            'label' => __('Crafts & Foods Image'),
                                            'type' => 'file',
                                            'class' => 'image_field'
                                        ]);
                                        ?>
                                        <div class="form-group remove-area" style="display:none;">
                                            <?php echo $this->Form->button(__('Remove'), ['type' => 'button', 'class' => 'btn btn-warning removeimage', 'data-removeid' => 0]); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <?php echo $this->Form->button(__('Add More'), ['type' => 'button', 'id' => 'addmoreimage', 'class' => 'btn btn-success', 'style' => 'margin-top: 20px;']); ?>
                            </div>
							 </div>
                            <div class="col-md-6">
							<div id="myMap"></div><br/>
							<div>
								<?= $this->Form->input('latitude', ['type' => 'hidden', 'value' => $craftfood->id]) ;?>
								<?= $this->Form->input('longitude', ['type' => 'hidden', 'value' => $craftfood->id]) ;?>
							</div>
						</div>
                    </div>
					</div>
					</div>
                </div>
				<div class="box-footer">
                                <?php echo $this->Form->button(__('Submit')) ?>
								<?php  echo $this->Html->link('<div class="btn btn-success">Cancel</div>', ['action' => 'index'], ['class' => 'btn btn-sm text-success', 'escape' => false, 'title'=>'Cancel']) ?>
                            </div>
                <?php echo $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>
<?php // $this->start('scriptBotton'); ?>
<style>
        #myMap {
		   height: 350px;
		   width: 350px;
		}
        </style>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBemfQhlJ1Tv9uOb5mIjMoMhztkR9CI5NM&sensor=false"></script>
<?php $this->Html->script(['eventMap.js'],['block' => 'script']); ?>
<?php // $this->end('scriptBotton'); ?>