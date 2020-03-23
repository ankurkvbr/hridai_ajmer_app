<?php echo $this->Html->script('ckeditor/ckeditor');?>
<?php $this->Html->script(['jquery.validate'],['block' => 'script']); ?>
<?php $this->Html->script(['Event.js'],['block' => 'script']); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= __('Edit Fairs & Festivals') ?></h1>
    <?php $this->Html->addCrumb(__('Fairs & Festivals List'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Fairs & Festivals Event'), 'javascript:void(0);', ['class' => 'active'] ); ?>
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
              <?= $this->Form->create($event,['id' => 'event','class'=>'editEvent','type' =>'file']) ?>
				<div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
							<div class="form-group">
								<?= $this->Form->input('lang',array('options'=>[''=>'English','hi'=>'Hindi'],'label'=>['text'=>'Select Language'])); ?>
                            </div>
							<div class="form-group">
								<?= $this->Form->input('event_name',
								['autocomplete' => 'off',
								'label' => __('Name'),
								'placeholder' => __('Name'),
								'label'=>['text'=>'Name<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
							</div>
							<div class="col-md-10">	
							 <div class="form-group">
								<?php echo $this->Form->input('event_description',['id' => 'description','label'=>['text'=>'Description<span class="red"> * </span>','escape'=>false]]); ?>
                            <script>
								var FileManager = '<?=$this->Url->build('/filemanager/');?>';
								CKEDITOR.replace( 'event_description',{
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
                                    echo $this->Form->input('address', [
										'label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false],
										//'readonly' => 'readonly',
										'type' => 'text',
										'empty' => __('Please enter address'),
										'required' => true,
									]); 
                                } else{
                                    echo $this->Form->input('address', [
										'label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false],
										//'readonly' => 'readonly',
										'type' => 'text',
										'empty' => __('Please enter address'),
										'required' => true,
									]); 
                                }
                            ?>

							<!--<div class="form-group">
								<?= $this->Form->input('state_id', [
								'label'=>['text'=>'State<span class="red"> * </span>','escape'=>false],
								'options' => $states,
								'type' => 'select',
								'empty' => __('Please select State'),
								'required' => true
							]); ?>
                            </div> 
							 <div class="form-group">
								 <?= $this->Form->input('city_id', [
									'label'=>['text'=>'City<span class="red"> * </span>','escape'=>false],
									'options' => $cities,
									'type' => 'select',
									'empty' => __('Please select city'),
									'required' => true
									]); ?>
							 </div>--> 
<?php 
								$cmsPage_created_at_AM = str_replace('पूर्वाह्न', 'AM',$event->even_date_time);
                                $cmsPage_created_at_PM = str_replace('अपराह्न', 'PM',$event->even_date_time);
                                $cmsPage_created_at = (strpos($cmsPage_created_at_PM,'PM')) ? $cmsPage_created_at_PM : $cmsPage_created_at_AM;
                                if($language == 'hi'){
                                    $asCreated_at = explode('/',$cmsPage_created_at);

                                    $asCreated_at = explode('-',$asCreated_at[0]);

                                    if(isset($asCreated_at[1]) && $asCreated_at[2]){
                                        $event_date_time = $asCreated_at[1].'/'.$asCreated_at[0].'/'.$asCreated_at[2];
                                    }                                    
                                }else{
                                    $event_date_time =$event->even_date_time;
                                }
?>

							<div class="form-group" id='datetimepicker4'>
								<?= $this->Form->input('even_date_time', 
									['label'=>['text'=>'Event Date<span class="red"> * </span>','escape'=>false],
									'placeholder' => __('Date'),
									'type' => 'text',
                                                                        'value'    => date("d/m/Y H:i",strtotime($event_date_time)),
									'class' =>'datetimepicker',
									'rule' => array('date','H:i:s'),
									]);
								?>
							</div>
                                                            
                                                            
                                                            

                            <div id="event-image-area">
								<?php 
  
                                                                if($event->has('event_images')){ ?>
									<?php $i = 0; ?>
									<?php 

                                                                        foreach($event->event_images as $imgKey => $image){ ?>
										<div style="display:none;">
											<?= $this->Form->input('event_images.'.$imgKey.'.id', ['type' => 'hidden','value' => $image->id]);
											?>
										</div>
										<div class="form-group" id="field-<?= $imgKey;?>">
											<?= $this->Form->input('event_images.'.$imgKey.'.image',[
												'label' => ['text'=>'Event Image<span class="red"> * </span>','escape'=>false],
												'type' => 'file',
												'class' => (empty($image['image'])) ? 'image_field' : '',
												'required' => false
												]);
											?>
											<div class="form-group uploaded-area">
											<?php 
											if(!empty($image['image'])) {
												echo $this->Form->input('event_images.'.$imgKey.'.uploaded', ['type' => 'hidden','value' => $image['image']]);
												echo $this->Html->image('../resize/100x100/img/event/'.$image['image']);
											}
											?>
											</div>
											<div class="form-group remove-area">
													<?= $this->Form->button(__('Remove'), ['type' => 'button', 'class' => 'btn btn-warning deleteimage', 'data-removeid' => $imgKey, 'id' => $image->id]); ?>
											</div>
										</div>
									<?php } ?>
								<?php } else { 
                                                                    ?>
									<?= $this->Form->input('event_images.0.image',[
											'label'=>__('Event Image 1'),
											'type' => 'file',
											'class' => 'image_field'
											]);
										?>
									<img src="<?php echo '../../img/event/'.$event->event_images[0]->image; ?>" height="100" width="100">
									<div class="form-group" id="field-0">
										<div class="form-group remove-area" style="display:none;">
											<?= $this->Form->button(__('Remove'), ['type' => 'button', 'class' => 'btn btn-warning removeimage deleteimage', 'data-removeid' => 0]); ?>
										</div>
									</div>
								<?php } ?>
                            </div>                                                            

							<!--/.createEventForm .commonForm-->
							<!--.fieldRow-->
							<div class="form-group">
								<?= $this->Form->button(__('Add More'), ['type' => 'button', 'id' => 'addmoreimage', 'class' => 'btn btn-success', 'style' => 'margin-top: 20px;']); ?>
							</div>
							<div class="form-group">
								<?= $this->Form->input('is_active',array('type'=>'checkbox','default' => true) ,['options' => ['1' => __('Active'), '0' => __('Inactive')]]); ?>
							</div>
						</div>
						</div>
                                                <div class="col-md-6">
						<div id="myMap"></div><br/>
							<div>
								<?= $this->Form->input('latitude', ['type' => 'hidden', 'value' => $event->latitude]) ;?>
								<?= $this->Form->input('longitude', ['type' => 'hidden', 'value' => $event->longitude]) ;?>
							</div>

						</div>
						</div>
                                                            
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?= $this->Form->button(__('Submit')) ?>
					<?php  echo $this->Html->link('<div class="btn btn-success">Cancel</div>', ['action' => 'index'], ['class' => 'btn btn-sm text-success', 'escape' => false, 'title'=>'Cancel']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
    </div>
    <!-- /.row -->
</section>
<?php

$this->Html->css([
    'AdminLTE./plugins/datetimepicker/bootstrap-datetimepicker.min',
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./plugins/datetimepicker/moment',
  'AdminLTE./plugins/datetimepicker/bootstrap-datetimepicker.min',
],
['block' => 'script']);
?>


<?php $this->start('scriptBotton'); ?>
<script type="text/javascript">
 $(document).ready(function () {
		//Add / Edit
		$("#lang").change(function(){
			window.location.href = '<?php  echo $this->Url->build(["action" => "edit",$event->id,"?" => ["lang" => ""]]); ?>'+$(this).val();
		});
	});
	
   // var getCityByState = "<?php echo $this->Url->build(['controller' => 'event', 'action' => 'getCityByState']); ?>";
    var deleteimage = "<?php echo $this->Url->build(['controller' => 'event', 'action' => 'deleteimage']); ?>";

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
