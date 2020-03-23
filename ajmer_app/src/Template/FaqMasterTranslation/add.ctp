<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Faq Master Translation'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Faq Master'), ['controller' => 'FaqMaster', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Faq Master'), ['controller' => 'FaqMaster', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="faqMasterTranslation form large-9 medium-8 columns content">
    <?= $this->Form->create($faqMasterTranslation) ?>
    <fieldset>
        <legend><?= __('Add Faq Master Translation') ?></legend>
        <?php
            //echo $this->Form->input('faq_master_id', ['options' => $faqMaster]);
            echo $this->Form->input('faq_title',array('type'=>'text'));
            echo $this->Form->input('faq_description',array('type' => 'textarea'));
            echo $this->Form->input('lang');
           
			echo $this->Form->input('IsActive', ['options' => ['1' => __('Active'), '0' => __('Inactive')],'type'=>'checkbox',['label'=>'Status*']]); 
			
           // echo $this->Form->input('created_at');
           // echo $this->Form->input('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
