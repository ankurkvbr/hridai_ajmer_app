<?php $this->Html->script(['jquery.validate'],['block' => 'script']); ?>
<?php $this->Html->script(['jquery-ui.js'],['block' => 'script']); ?>
<section class="content-header">
    <h1><?= __('Edit User') ?></h1>
    <?php $this->Html->addCrumb(__('User Management'), ['action' => 'index']); ?>
    <?php $this->Html->addCrumb(__('Edit User'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?= $this->Html->getCrumbList(
        ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false],
        ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    ); ?>
</section>
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure want to delete this record?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>-->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-xs-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- <div class="box-header with-border">-->
                <!--<h3 class="box-title">Create Department</h3>-->
                <!--</div>-->
                <!-- /.box-header -->
                <!-- form start -->
                <?= $this->Form->create($user) ?>
                <div class="box box-primary">
               
                <?= $this->Form->create($user,['id' => 'userfrm']) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $this->Form->input('first_name',['label'=>['text'=>'First Name<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
							<div class="form-group">
                                <?= $this->Form->input('last_name',['label'=>['text'=>'Last Name<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>

                            <div class="form-group">
                                <?= $this->Form->input('email',['label'=>['text'=>'Email<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('address',['label'=>['text'=>'Address<span class="red"> * </span>','escape'=>false]]); ?>
                            </div>
							  <div class="form-group">
                                 <?= $this->Form->input('state_id',
								['label'=> ['text'=>'State<span class="red"> * </span>','escape'=>false],
								 'id' => 'state_id',
								 'options' => $states,
								 'type' => 'Select',
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
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('mobile_no',['label'=>['text'=>'Mobile No<span class="red"> * </span>','escape'=>false],'class'=>'isNumeric','type'=>'text' ,'maxlength'=>'10']); ?>
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('dob',['label'=>['text'=>'Date Of Birth','escape'=>false],'type' => 'text','class' => 'datepicker','value' => ($user->dob && strtotime($user->dob) > 0) ? h( date("d/m/Y", strtotime($user->dob))) : '',]); ?>
                            </div>
							 <div class="form-group">
                                <?= $this->Form->input('postal_code',['label'=>['text'=>'Postal Code<span class="red"> * </span>','escape'=>false],'class'=>'isNumeric','type'=>'text' ,'maxlength'=>'6']); ?>
                            </div>
                            
                           <div class="form-group">
                                <?= $this->Form->input('status',array('type'=>'checkbox') ,['options' => ['Yes' => __('Active'), 'No' => __('Inactive')]]); ?>
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
	</div>
    <!-- /.row -->
</section>

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
