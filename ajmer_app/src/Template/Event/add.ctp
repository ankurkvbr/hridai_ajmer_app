<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php echo $this->Html->script('ckeditor/ckeditor');?>
<?php $this->Html->script(['jquery.validate'],['block' => 'script']); ?>
<?php $this->Html->script(['Event.js'],['block' => 'script']); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= __('Add Fairs & Festivals') ?></h1>
    <?php $this->Html->addCrumb(__('Fairs & Festivals List'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Add Fairs & Festivals'), 'javascript:void(0);', ['class' => 'active'] ); ?>
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
              <?= $this->Form->create($event,['id' => 'event','type' =>'file']) ?>
				<?php /*<div style="display:none;">
					<?= (!empty($event->id)) ? $this->Form->input('id', ['type' => 'hidden', 'value' => $event->id]) : '' ;?>
				</div> */
				//pr($event->event_images[0]['image']);exit;
				?>
				<div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
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
                                <?php echo $this->Form->input('event_description',['id' => 'event_description','label'=>['text'=>'Description<span class="red"> * </span>','escape'=>false]]); ?>
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
								echo $this->Form->input('address', [
									'label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false],
								//	'readonly' => 'readonly',
									'type' => 'text',
									'empty' => __('Please enter address'),
									'required' => true,
									'onchange' => 'codeAddress()'
								]);                                                             

							?>
                            </div> 
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
							<div class="form-group" id='datetimepicker4'>
								<?= $this->Form->input('even_date_time', 
									['label'=>['text'=>'Event Date<span class="red"> * </span>','escape'=>false],
									'placeholder' => __('Date'),
									'type' => 'text',
									'class' =>'datetimepicker',
									'rule' => array('date','H:i:s'),
									]);
								?>
							</div>
							<!--Add new span tag for wrap the add more functionality-->
                                                        
                                                        <div id="event-image-area">
                                                            <?php if ($event->has('event_images')) { ?>
                                                                <?php foreach ($event->event_images as $imgKey => $image) { ?>
                                                                    <div class="form-group" id="field-<?php echo $imgKey; ?>">
                                                                        <?php echo
                                                                        $this->Form->input('event_images.' . $imgKey . '.image', [
                                                                            'label' => ['text'=>'Event Image<span class="red"> * </span>','escape'=>false],
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
                                                                    $this->Form->input('event_images.0.image', [
                                                                        'label' => ['text'=>'Event Image<span class="red"> * </span>','escape'=>false],
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
                                                        
							<!--/.createEventForm .commonForm-->
							<!--.fieldRow-->
							<div class="form-group">
                                                                <?php echo $this->Form->button(__('Add More'), ['type' => 'button', 'id' => 'addmoreimage', 'class' => 'btn btn-success', 'style' => 'margin-top: 20px;']); ?>
							</div>
							<div class="form-group">
								<?= $this->Form->input('is_active',array('type'=>'checkbox','default' => true) ,['options' => ['1' => __('Active'), '0' => __('Inactive')]]); ?>
							</div>
						</div>
						<div class="col-md-6">
						<div id="myMap"></div><br/>
							<div>
								<?= $this->Form->input('latitude', ['type' => 'hidden', 'value' => $event->id]) ;?>
								<?= $this->Form->input('longitude', ['type' => 'hidden', 'value' => $event->id]) ;?>
							</div>
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
<?php // $this->start('scriptBotton'); ?>
<script type="text/javascript">
    var getCityByState = "<?php echo $this->Url->build(['controller' => 'Event', 'action' => 'getCityByState']); ?>";
</script>
<?php // $this->end('scriptBotton'); ?>
<style>
        #myMap {
		   height: 350px;
		   width: 350px;
		}
        </style>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBemfQhlJ1Tv9uOb5mIjMoMhztkR9CI5NM&sensor=false"></script>
<?php $this->Html->script(['eventMap.js'],['block' => 'script']); ?>
        <script type="text/javascript"> 
           /*  var map;
            var marker;
            var myLatlng = new google.maps.LatLng(26.4498954,74.63991629999998);
            var geocoder = new google.maps.Geocoder();
            var infowindow = new google.maps.InfoWindow();
            function initialize(){
                var mapOptions = {
                    zoom: 16,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
		       
                map = new google.maps.Map(document.getElementById("myMap"), mapOptions);
                
                marker = new google.maps.Marker({
                    map: map,
                    position: myLatlng,
                    draggable: true 
                });     
                
                geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#address').val(results[0].formatted_address);
                            $('#latitude').val(marker.getPosition().lat());
                            $('#longitude').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });

                               
                google.maps.event.addListener(marker, 'dragend', function() {

                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#address').val(results[0].formatted_address);
                            $('#latitude').val(marker.getPosition().lat());
                            $('#longitude').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });
            });
            
            }
            
            google.maps.event.addDomListener(window, 'load', initialize);
			
			function codeAddress() {
				var address = document.getElementById('address').value;
				geocoder.geocode( { 'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
					if (marker) {
					   marker.setMap(null);
					   if (infowindow) infowindow.close();
					}
					marker = new google.maps.Marker({
						map: map,
						draggable: true,
						position: results[0].geometry.location
					});
					$('#latitude').val(marker.getPosition().lat());
					$('#longitude').val(marker.getPosition().lng())
					google.maps.event.addListener(marker, 'dragend', function() {
						geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							if (results[0]) {
								$('#address').val(results[0].formatted_address);
								$('#latitude').val(marker.getPosition().lat());
								$('#longitude').val(marker.getPosition().lng());
								infowindow.setContent(results[0].formatted_address);
								infowindow.open(map, marker);
							}
						}
					});
				});
				
			   } else {
				alert('Geocode was not successful for the following reason: ' + status);
			  }
			});
		} */
        </script>
