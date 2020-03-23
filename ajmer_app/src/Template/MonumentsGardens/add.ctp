<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php echo $this->Html->script('ckeditor/ckeditor');?>
<?php // $this->Html->script(['jquery-min.js'], ['block' => 'script']); ?>
<?php $this->Html->script(['jquery.validate'], ['block' => 'script']); ?>
<?php $this->Html->script(['monumentsgardens.js'], ['block' => 'script']); ?>

<section class="content-header">
    <h1><?php echo __('Add Discoveries') ?></h1>
    <?php $this->Html->addCrumb(__('Discoveries List'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Add Discoveries'), 'javascript:void(0);', ['class' => 'active']); ?>
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
                <?php echo $this->Form->create($monumentsgardens, ['id' => 'monumentsgardens', 'type' => 'file']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!--<div class="form-group">
                                <?php
                                
                                /*echo $this->Form->input('monuments_category', [
                                    'label' => __('Monuments Category'),
                                    'options' => array(""=>'Please select category',  1=>'Monuments', 2=>'Gardens'),
                                    'type' => 'select',
                                    'empty' => __('Please select category'),
                                    'required' => true
                                ]);*/
 
                                ?>
                            </div>-->
                            <div class="form-group">
                                <?php echo $this->Form->input('title',['label'=>['text'=>'Title<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
							</div>
							 <div class="col-md-10">
                            <div class="form-group">
                                <?php echo $this->Form->input('description',['id' => 'description','label'=>['text'=>'Description<span class="red"> * </span>','escape'=>false]]); ?>
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
							<div class="row">
							 <div class="col-md-6">
                            <div class="form-group">
                                <?php                                  
                                    echo $this->Form->input('address',[
									'label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false],
									//'readonly' => 'readonly',
									'empty' => __('Please enter Address'),
									'required' => true,]);
                                ?>
                                
                            </div>
                            <div class="form-group">
                                <?php echo $this->Form->input('tour_title',['label'=>['text'=>'Tour Title<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $this->Form->input('tour_video',['label'=>['text'=>'Tour Video','escape'=>false],'novalidate',
											'required' => false]); ?>
                            </div>

                            <!--<div class="form-group">
                                <?php
                               /* echo $this->Form->input('state_id', [
                                    'label'=>['text'=>'State<span class="red"> * </span>','escape'=>false],
                                    'options' => $states,
                                    'type' => 'select',
                                    'empty' => __('Please select State'),
                                    'required' => true
                                ]);*/
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                               /* echo $this->Form->input('city_id', [
                                   'label'=>['text'=>'City<span class="red"> * </span>','escape'=>false],
                                    'options' => $cities,
                                    'type' => 'select',
                                    'empty' => __('Please select city'),
                                    'required' => true
                                ]);*/
                                ?>
                            </div>-->
                            
                            <div class="form-group">
                                    <?php echo
                                        $this->Form->input('audio', [
                                            'label'=>['text'=>'Audio','escape'=>false],
                                            'type' => 'file',
                                            'class' => 'image_field',
											'novalidate',
											'required' => false
                                        ]);
                                        ?>
                            </div>
                            <div class="form-group">
                                    <?php echo
                                        $this->Form->input('audio_cover_image', [
                                            'label'=>['text'=>'Audio Cover Image','escape'=>false],
                                            'type' => 'file',
                                            'class' => 'image_field_audio_cover',
											'novalidate',
											'required' => false
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
                                <?php if ($monumentsgardens->has('monumentsgardens_images')) { ?>
                                    <?php foreach ($monumentsgardens->monumentsgardens_images as $imgKey => $image) { ?>
                                        <div class="form-group" id="field-<?php echo $imgKey; ?>">
                                            <?php echo
                                            $this->Form->input('monumentsgardens_images.' . $imgKey . '.image', [
                                                'label' => __('Discovery Image'),
                                                'type' => 'file',
                                                'class' => 'image_field_audio_cover'
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
                                        $this->Form->input('monumentsgardens_images.0.image', [
                                            'label' => __('Discovery Image'),
                                            'type' => 'file',
                                            'class' => 'image_field_audio_cover'
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
								<?= $this->Form->input('latitude', ['type' => 'hidden', 'value' => $monumentsgardens->id]) ;?>
								<?= $this->Form->input('longitude', ['type' => 'hidden', 'value' => $monumentsgardens->id]) ;?>
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

<!--<script type="text/javascript">
    var getCityByState = "<?php echo $this->Url->build(['controller' => 'Event', 'action' => 'getCityByState']); ?>";
</script>-->
<style>
        #myMap {
		   height: 350px;
		   width: 350px;
		}
        </style>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBemfQhlJ1Tv9uOb5mIjMoMhztkR9CI5NM&sensor=false"></script>
<?php $this->Html->script(['eventMap.js'],['block' => 'script']); ?>
<?php // $this->end('scriptBotton'); ?>