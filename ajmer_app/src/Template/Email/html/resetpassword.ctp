<?php /*<p><?= __('Dear').' '.$user->name; ?>,</p> */ ?>
<p><?=__('You password reset successfully');?></p>
<p><?= __('Visit : ');?>
	<?= $this->Html->link($this->Url->build(['controller'=>'Users','action'=>'login','_full'=>true]),
		['controller'=>'Users','action'=>'login','_full'=>true],
		['escape'=>false]
	); ?></p>
<p><?=__('Thanks and have a nice day!');?></p>