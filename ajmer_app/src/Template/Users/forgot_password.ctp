<?php $this->Html->script(['jquery.validate'],['block' => 'script']); ?>
<?php $this->layout = "login";?>
<div class="users form small-centered large-4 medium-6 columns content">
    <?= $this->Form->create(null,['id' => 'forgotpasswordFrm']) ?>
    <fieldset>
        <legend><?= __('Forgot Password') ?></legend>
        <?php echo $this->Form->input('email',['required'=>true]);?>
    </fieldset>
	<div class="row">
        <div class="col-xs-6">
            <?= $this->Html->link(__('Login'), ['action' => 'login'], ['class' => 'btn btn-link']) ?>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <?= $this->Form->button(__('Forgot Password')) ?>
        </div>
        <!-- /.col -->
    </div>
    <?= $this->Form->end() ?>
</div>
<?php $this->start('scriptBotton'); ?>
<script>
	$(document).ready(function () {
		//Add / Edit
		$("#forgotpasswordFrm").validate({
			rules: {
				"email": {required: true}
				
				
			},
			messages: {
				"username": {required: "Please Enter Username"}
				
				
			},
		});
	});
</script>
<?php $this->end('scriptBotton'); ?>