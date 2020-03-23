<?php // $this->Html->script(['jquery-min.js'], ['block' => 'script']); ?>
<?php echo $this->Html->script('ckeditor/ckeditor');?>
<?php $this->Html->script(['jquery.validate'], ['block' => 'script']); ?>
<?php $this->Html->script(['project.js'], ['block' => 'script']); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Add Project') ?></h1>
    <?php $this->Html->addCrumb(__('Project List'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Add Project'), 'javascript:void(0);', ['class' => 'active']); ?>
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
                <?php echo $this->Form->create($project, ['id' => 'project', 'type' => 'file']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo $this->Form->input('project_name',['label'=>['text'=>'Project Name<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
							</div>
							<div class="col-md-10">
                            <div class="form-group">
                                <?php echo $this->Form->input('project_description',['id' => 'project_description','label'=>['text'=>'Project Description<span class="red"> * </span>','escape'=>false]]); ?>
                            <script>
						var FileManager = '<?=$this->Url->build('/filemanager/');?>';
						CKEDITOR.replace( 'project_description',{
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
									//'readonly' => 'readonly',
									'empty' => __('Please enter Address'),
									'required' => true,
									]); 

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
                                    'empty' => __('Please select city'),
                                    'required' => true
                                ]);
                                ?>
                            </div>-->
                            <div class="form-group">
                                <?php echo $this->Form->input('is_active',array('type'=>'checkbox','default' => true) ,['options' => ['1' => __('Active'), '0' => __('Inactive')]]); ?>
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
                                <?php if ($project->has('project_images')) { ?>
                                    <?php foreach ($project->project_images as $imgKey => $image) { ?>
                                        <div class="form-group" id="field-<?php echo $imgKey; ?>">
                                            <?php echo
                                            $this->Form->input('project_images.' . $imgKey . '.image', [
                                                'label' => __('Project Image'),
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
                                        $this->Form->input('project_images.0.image', [
                                            'label' => __('Project Image'),
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
								<?= $this->Form->input('latitude', ['type' => 'hidden', 'value' => $project->id]) ;?>
								<?= $this->Form->input('longitude', ['type' => 'hidden', 'value' => $project->id]) ;?>
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
<script type="text/javascript">
    var getCityByState = "<?php echo $this->Url->build(['controller' => 'Event', 'action' => 'getCityByState']); ?>";
//    $(document).ready(function () {
//        $(".removeimage").click(function(){
//            alert();
//            $(this).find('.form-group').remove();
//        })
//    })
</script>
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
<?php // $this->end('scriptBotton'); ?>