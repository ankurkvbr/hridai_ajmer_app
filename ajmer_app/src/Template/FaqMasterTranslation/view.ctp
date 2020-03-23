<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Faq Master Translation'), ['action' => 'edit', $faqMasterTranslation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Faq Master Translation'), ['action' => 'delete', $faqMasterTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $faqMasterTranslation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Faq Master Translation'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Faq Master Translation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Faq Master'), ['controller' => 'FaqMaster', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Faq Master'), ['controller' => 'FaqMaster', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="faqMasterTranslation view large-9 medium-8 columns content">
    <h3><?= h($faqMasterTranslation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Faq Master') ?></th>
            <td><?= $faqMasterTranslation->has('faq_master') ? $this->Html->link($faqMasterTranslation->faq_master->id, ['controller' => 'FaqMaster', 'action' => 'view', $faqMasterTranslation->faq_master->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lang') ?></th>
            <td><?= h($faqMasterTranslation->lang) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($faqMasterTranslation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($faqMasterTranslation->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($faqMasterTranslation->updated_at) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Faq Title') ?></h4>
        <?= $this->Text->autoParagraph(h($faqMasterTranslation->faq_title)); ?>
    </div>
    <div class="row">
        <h4><?= __('Faq Description') ?></h4>
        <?= $this->Text->autoParagraph(h($faqMasterTranslation->faq_description)); ?>
    </div>
</div>
