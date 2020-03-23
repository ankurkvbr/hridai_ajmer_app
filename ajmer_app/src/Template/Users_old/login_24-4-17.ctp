<?php //$this->Html->script(['jquery.validate'],['block' => 'script']); ?>
<?php $this->layout = "login"; ?>
<div class="users form small-centered large-4 medium-6 columns content">
    <?= $this->Form->create(null,['id' => 'loginFrm','name'=>'loginFrm']) ?>
    <fieldset>
        <legend><?= __('Login') ?></legend>
        <?php echo $this->Form->input('email'); ?>
        <?php echo $this->Form->input('password'); ?>
        <?php echo $this->SimpleCaptcha->input([
            'label' => ':question ',
            'placeholder' => __('Calculation'),
            'class' => 'captcha'
        ]); ?>
    </fieldset>
    <div class="row">
        <div class="col-xs-8">
            <?= $this->Html->link(__('Forgot Password?'), ['action' => 'forgotPassword'], ['class' => 'btn btn-link']) ?>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            <?= $this->Form->button(__('Login'),['id'=>'loginBtn']) ?>
        </div>
        <!-- /.col -->
    </div>
    <?= $this->Form->end() ?>
</div>


<script src="/ajmerapp/trunk/source/admin_l_t_e/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="/ajmerapp/trunk/source/js/jquery.validate.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$("body").on('click', '#loginBtn', function() {
			//$(this).validate();
			
		$("#loginFrm").validate({
        /*focusInvalid: false,
        errorContainer: "#messagebox1",
        errorLabelContainer: "#messageBox",*/
        errorElement: 'span',
        errorClass: "error",
        rules: {
                  'email': {
                      required: true,
                  },
                  'password': {
                      required: true,
                  },
                  'captcha': {
                      required: true,
                  },
            },
            messages: {
                 'email': {
                      required: "Please enter username.",
                  },
                  'password': {
                      required: "Please enter password.",
                  },
                  'captcha': {
                      required: "Please enter captcha.",
                  },
              },
              errorPlacement: function(error, element) {
                    error.insertAfter(element);
              },
        });
	  });
	});
</script>