<?php /*<p><?= __('Dear').' '.$user->name; ?>,</p> */ ?>
<p><?=__('We header that you lost your password,Sorry about that!');?></p>
<p><?=__('But don\'t worry! You can use the following link within the next day to reset your password:');?></p>
<?php $url = str_replace('api/', '', $this->Url->build(['controller'=>'Users','action'=>'resetPassword',$user->fp_token,'_full'=>true])) ;?>

<a href="<?php echo $url?>"><?php echo $url?></a>

<!-- <p><?=$this->Html->link(
		$url ,
		['controller'=>'Users','action'=>'resetPassword',$user->fp_token,'_full'=>true],
		['escape'=>false]
	); ?></p>
-->

<p><?=__('If you don\'t use this link within 24 hours, it will expire. To get a new password reset link,');?></p>
<p><?= __('Visit : ');?>
	<?php $urlForgetPassword = str_replace('api/', '', $this->Url->build(['controller'=>'Users','action'=>'forgotPassword','_full'=>true])); ?>
	
	<!--<?= $this->Html->link(
		$this->Url->build(['controller'=>'Users','action'=>'forgotPassword','_full'=>true]),
		['controller'=>'Users','action'=>'forgotPassword','_full'=>true],
		['escape'=>false]
	); ?>-->
	<a href="<?php echo $urlForgetPassword ?>"><?php echo $urlForgetPassword ?></a>
</p>
<p><?=__('Thanks and have a nice day!');?></p>