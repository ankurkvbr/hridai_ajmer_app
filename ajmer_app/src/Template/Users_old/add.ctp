<?php $this->Html->script(['jquery.validate'],['block' => 'script']); ?>
<?php $this->Html->script(['jquery-ui.js'],['block' => 'script']); ?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1><?= __('Add New User') ?></h1>
    <?php $this->Html->addCrumb(__('User Management'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Add New User'), 'javascript:void(0);', ['class' => 'active']); ?>
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
               
                <?= $this->Form->create($user,['id' => 'userfrm']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
								<?= $this->Form->input('first_name',['autocomplete' => 'off','label'=>['text'=>'First Name<span class="red"> * </span>','id' => 'folderName','escape'=>false]]); ?>
                            </div>
							<div class="form-group">
                                <?= $this->Form->input('last_name',['label'=>['text'=>'Last Name<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->input('password',['id'=>'password','label'=>['text'=>'Password<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('confirm_password',['type'=>'password','label'=>['text'=>'Confirm Password<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->input('email',['label'=>['text'=>'Email<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('address',['label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false], 'class' => 'alpha']); ?>
                            </div>
							 <!--<div class="form-group">
                                 <?= $this->Form->input('state_id',
								 ['label' => ['text'=>'State<span class="red"> * </span>','escape'=>false],
								 'id' => 'state_id',
								 'options' => $states,
								 'empty'=>'Select State',
								 'data-attr'=>$this->Url->build(['controller'=>'Cities','action'=>'getCityByState']),
								'onchange'=>'getCityByState(this.id,city_id.id)',true]); ?>
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('city_id',[
								'id' => 'city_id',
								'type' => 'Select',
								'label'=> ['text'=>'City<span class="red"> * </span>','escape'=>false],
								'options'=>$citys, 
								'empty'=>'Select City',]); ?>
                            </div>-->
							 <div class="form-group">
                                <?= $this->Form->input('mobile_no',['label'=>['text'=>'Mobile No<span class="red"> * </span>','escape'=>false],'class'=>'isNumeric', 'id'=>'txtPhn', 'type'=>'text' ,'maxlength'=>'10']); ?>
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('dob',['label'=>['text'=>'Date Of Birth','escape'=>false],'type' => 'text','id'=>'datepicker','class' => 'datepicker','runat'=>'server']); ?>
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('postal_code',['class'=>'isNumeric','type'=>'text' ,'maxlength'=>'6']); ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->input('status',array('type'=>'checkbox','default' => true) ,['options' => ['Yes' => __('Active'), 'No' => __('Inactive')]]); ?>
								
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
<!--/.content-->
<?php $this->start('scriptBotton'); ?>
<script> 
	 jQuery(document).ready(function () {
		 
		//Add / Edit
		jQuery("#userfrm").validate({
			errorContainer 		: "#messagebox1",
            errorLabelContainer	: "#messageBox",
            wrapper				: "div",
            errorClass			: "error1",
			rules			: {
				'first_name':{
					required: {
						depends:function(){
							$(this).val($.trim($(this).val()));
							return true;
						}
					}
				},
				'last_name': {
					required: {
						depends:function(){
							$(this).val($.trim($(this).val()));
							return true;
						}
					}
				},
				'password': {
					required: {
						depends:function(){
							$(this).val($.trim($(this).val()));
							return true;
						}
					}
				},
				'confirm_password': {
					required: {
						depends:function(){
							$(this).val($.trim($(this).val()));
							return true;
						}
					},equalTo: "#password"
				},
				'email': {
					required: {
						depends:function(){
							$(this).val($.trim($(this).val()));
							return true;
						}
					}
				},
				'address': {
					required: {
						depends:function(){
							$(this).val($.trim($(this).val()));
							return true;
						}
					}
				},
				'state': {required: true},
				'city': {required: true},
				'mobile_no': {
					required: true,
					minlength: 10,
					maxlength: 10
				},
				//'dob': {required: true}
				'postal_code':{
					required: true,
					minlength: 6,
					maxlength: 6
				
				}
			},
			messages: {
				'first_name':{required: 'Please Enter First Name'},
				'last_name': {required: 'Please Enter Last Name'},
				'password': {required: 'Please Enter Password'},
				'confirm_password': {required: 'Please Enter Confirm Password'},
				'email': {required: 'Please Enter Email'},
				'address': {required: 'Please Enter Address'},
				'state': {required: 'Please Select State'},
				'city': {required: 'Please Select City'},
				'mobile_no': {
					required: 'Please Enter Mobile Number',
					maxlength: 'Mobile Number must be 10 digits',
					minlength: 'Mobile Number must be 10 digits'
				},
				//'dob': {required: 'Please Select Date Of Birth'}
				'postal_code':{
					required:'Please  Enter Postal Code',
					maxlength: 'Postal Code Number must be 6 digits',
					minlength: 'Postal Code must be 6 digits'
				}
			},
		});
		

		$(".isNumeric").keypress(function (e) {
			var e = e || window.event;
			var key = e.keyCode || e.which;
			if (key == 8 || key == 9) {
				return true;
			}
			else if (String.fromCharCode(key).match(/[^0-9]/g)) {
				return false;
			}
		}); 
	
	});
	
	function getCityByState(ele,city_id){
		var ele = $("#"+ele);
		var cityEle = $('#'+city_id);
		var state_id = ele.val();
		var getCities = ele.attr('data-attr');
		//console.log(getCities);
		//$('#loader').show();
    
        $.ajax({
            method:'POST',
            url:getCities,
            data:{'state_id':state_id},
            dataType:'json',
        }).done(function(jsonData){
            var result = [];
            result = jsonData.citydata;
            cityEle.html("");
            cityEle.html("<option value=''>Select City</option>");
            $.each(jsonData.citydata, function(id,textVal) {
                cityEle.append($('<option>').text(textVal).attr('value', id));
            });
            //$('#loader').hide();
        }).fail(function(data){
                cityEle.html("");
                cityEle.html("<option value=''>Select City</option>");  
                $('#loader').hide();
        });
   
	}

</script>


<?php
$this->Html->css([
    'AdminLTE./plugins/datepicker/datepicker3',
	'http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css',
  ],
  ['block' => 'css']);

$this->Html->script([
  'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',
  'AdminLTE./plugins/datepicker/bootstrap-datepicker',
  'http://code.jquery.com/ui/1.9.1/jquery-ui.js',
],
['block' => 'script']);
?>

<script type="text/javascript">
	$(function () {
		 var date = new Date();
		 var currentMonth = date.getMonth();
		 var currentDate = date.getDate();
		 var currentYear = date.getFullYear();

		 $('.datepicker').datepicker({
			 maxDate: new Date(currentYear, currentMonth, currentDate)
		 });
	 });
</script>


<?php $this->end('scriptBotton'); ?>
<!--
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('password');
            echo $this->Form->input('email');
            echo $this->Form->input('address');
           // echo $this->Form->input('state');
           // echo $this->Form->input('city');
            echo $this->Form->input('mobile_no');
            echo $this->Form->input('dob');
            echo $this->Form->input('postal_code');
            echo $this->Form->input('role_id');
           // echo $this->Form->input('registration_date', ['empty' => true]);
            //echo $this->Form->input('updated_by');
            //echo $this->Form->input('updated_date', ['empty' => true]);
           // echo $this->Form->input('device_type');
            //echo $this->Form->input('device_token');
            echo $this->Form->input('status');
           // echo $this->Form->input('fp_token');
            //echo $this->Form->input('fp_token_at', ['empty' => true]); 
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>-->
