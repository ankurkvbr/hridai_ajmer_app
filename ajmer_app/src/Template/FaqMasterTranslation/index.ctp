<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Faq Master Translation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Faq Master'), ['controller' => 'FaqMaster', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Faq Master'), ['controller' => 'FaqMaster', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="faqMasterTranslation index large-9 medium-8 columns content">
    <h3><?= __('Faq Master Translation') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('faq_master_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lang') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($faqMasterTranslation as $faqMasterTranslation): ?>
            <tr>
                <td><?= $this->Number->format($faqMasterTranslation->id) ?></td>
                <td><?= $faqMasterTranslation->has('faq_master') ? $this->Html->link($faqMasterTranslation->faq_master->id, ['controller' => 'FaqMaster', 'action' => 'view', $faqMasterTranslation->faq_master->id]) : '' ?></td>
                <td><?= h($faqMasterTranslation->lang) ?></td>
                <td><?= h($faqMasterTranslation->created_at) ?></td>
                <td><?= h($faqMasterTranslation->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $faqMasterTranslation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $faqMasterTranslation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $faqMasterTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $faqMasterTranslation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
