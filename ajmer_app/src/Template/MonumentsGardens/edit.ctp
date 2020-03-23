<?php use Cake\Core\Configure; 
echo $this->Html->script('ckeditor/ckeditor');?>
<?php $this->Html->script(['jquery.validate'], ['block' => 'script']); ?>
<?php $this->Html->script(['monumentsgardens.js'], ['block' => 'script']); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= __('Edit Discoveries') ?></h1>
    <?php $this->Html->addCrumb(__('Discoveries List'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Edit Discoveries'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?=
    $this->Html->getCrumbList(
            ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false], ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    );
    ?>
</section>
<?php //print_r($monumentsgardens);?>
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-xs-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <?= $this->Form->create($monumentsgardens, ['id' => 'monumentsgardens', 'class' => 'editmonumentsgardens', 'type' => 'file']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
							<div class="form-group">
								<?php  echo $this->Form->input('lang',array('options'=>[''=>'English','hi'=>'Hindi'],'label'=>['text'=>'Select Language'])); ?>
                            </div>
                            <!--<div class="form-group">
                                <?php
                                
                                /*echo $this->Form->input('monuments_category', [
                                    'label' => __('Monuments Category'),
                                    'options' => array(""=>'Please select category',  1=>'Monuments', 2=>'Gardens'),
                                    'type' => 'select',
                                    'default' => $monumentsgardens->category,
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
                                if($language == 'hi'){
                                    echo $this->Form->input('address',[
									'label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false],
									'empty' => __('Please enter Address'),
									'required' => true,
									]);     
                                }else{
                                    echo $this->Form->input('address',[
									'label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false],
									'empty' => __('Please enter Address'),
									'required' => true,
									]);     
                                }
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
                            </div>-->
                            <!--<div class="form-group">
                                <?php
                               /* echo $this->Form->input('city_id', [
                                    'label'=>['text'=>'City<span class="red"> * </span>','escape'=>false],
                                    'options' => $cities,
                                    'type' => 'select',
                                    'empty' => __('Please select city'),
                                    'value' => isset($monumentsgardens->cities_id) ? $monumentsgardens->cities_id : '',
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
                                            'required' => false
                                        ]);
                                        ?>
                            </div>
                            <div class="form-group uploaded-area">
                                <?php $path = $this->request->webroot.Configure::read('webroot.img')."monumentsgardens_audio/";
                                $audio_path = "http://" . $_SERVER['SERVER_NAME'] .'.'.$path.$monumentsgardens->audio;
                                ?>                                
                                <audio controls>    
                                    <source src="<?php echo $audio_path?>" type="audio/ogg">
                                    <source src="<?php echo $audio_path?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                                </audio>
                            </div>

                            <div class="form-group">
                                    <?php echo
                                        $this->Form->input('audio_cover_image', [
                                            'label'=>['text'=>'Audio Cover Image','escape'=>false],
                                            'type' => 'file',                                            
                                            'class' => 'image_field_audio_cover',
                                            'required' => false
                                        ]);
                                        ?>
                            </div>                            
                            <div class="form-group uploaded-area">
                            <?php 
                            if(!empty($monumentsgardens->audio_cover_image)) {
                                    echo $this->Form->input('audio_cover_image', ['type' => 'hidden','value' => $monumentsgardens->audio_cover_image]);
                                    echo $this->Html->image('../resize/100x100/img/monumentsgardens_audio_cover_image/'.$monumentsgardens->audio_cover_image);
                            }
                            ?>
                            </div>
                            <div id="event-image-area">
								<?php 
  
                                                                if($monumentsgardens->has('monuments_gardens_images')){ ?>
									<?php $i = 0; ?>
									<?php 

                                                                        foreach($monumentsgardens->monuments_gardens_images as $imgKey => $image){ ?>
										<div style="display:none;">
											<?= $this->Form->input('monumentsgardens_images.'.$imgKey.'.id', ['type' => 'hidden','value' => $image->id]);
											?>
										</div>
										<div class="form-group" id="field-<?= $imgKey;?>">
											<?= $this->Form->input('monumentsgardens_images.'.$imgKey.'.image',[
												'label'=>__('Discoveries Image'),
												'type' => 'file',
												'class' => (empty($image['image'])) ? 'image_field_audio_cover' : '',
												'required' => false
												]);
											?>
											<div class="form-group uploaded-area">
											<?php 
											if(!empty($image['image'])) {
												echo $this->Form->input('monumentsgardens_images.'.$imgKey.'.uploaded', ['type' => 'hidden','value' => $image['image']]);
												echo $this->Html->image('../resize/100x100/img/monumentsgardens/'.$image['image']);
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
									<?= $this->Form->input('monumentsgardens_images.0.image',[
											'label'=>__('Discoveries Image 1'),
											'type' => 'file',
											'class' => 'image_field_audio_cover'
											]);
										?>
                                                                        <img src="<?php echo '../../img/monumentsgardens/'.$monumentsgardens->monuments_gardens_images[0]->image; ?>" height="100" width="100">
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
								<?= $this->Form->input('latitude', ['type' => 'hidden', 'value' => $monumentsgardens->latitude]) ;?>
								<?= $this->Form->input('longitude', ['type' => 'hidden', 'value' => $monumentsgardens->longitude]) ;?>
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
		$("#lang").change(function(){
			window.location.href = '<?php  echo $this->Url->build(["action" => "edit",$monumentsgardens->id,"?" => ["lang" => ""]]); ?>'+$(this).val();
		});
	});
	
    //var getCityByState = "<?php echo $this->Url->build(['controller' => 'monumentsgardens', 'action' => 'getCityByState']); ?>";
    var deleteimage = "<?php echo $this->Url->build(['controller' => 'MonumentsGardens', 'action' => 'deleteimage']); ?>";
	
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