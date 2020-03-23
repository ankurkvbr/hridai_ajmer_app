<?php $this->layout = "login";?>
<div class="users form small-centered large-4 medium-6 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Reset Password') ?></legend>
        <?php echo $this->Form->input('password',['type'=>'password','required'=>true]);?>
		<?php echo $this->Form->input('confirm_password',['type'=>'password','required'=>true]); ?>
		<?php echo $this->SimpleCaptcha->input([
						'label' => ':question ',
						'placeholder'=>__('Calculation'),
						'class'=>'captcha',
						'required'=>true,
						'title'=>__('Calculation field is required')
					]); ?>
    </fieldset>
	<div class="row">
        <div class="col-xs-6">
            <?= $this->Html->link(__('Login'), ['action' => 'login'], ['class' => 'btn btn-link']) ?>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <?= $this->Form->button(__('Reset Password')) ?>
        </div>
        <!-- /.col -->
    </div>
    <?= $this->Form->end() ?>
</div>
