<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cms Page Translation'), ['action' => 'edit', $cmsPageTranslation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cms Page Translation'), ['action' => 'delete', $cmsPageTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cmsPageTranslation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cms Page Translation'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cms Page Translation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cms Page'), ['controller' => 'CmsPage', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cms Page'), ['controller' => 'CmsPage', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cmsPageTranslation view large-9 medium-8 columns content">
    <h3><?= h($cmsPageTranslation->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cms Page') ?></th>
            <td><?= $cmsPageTranslation->has('cms_page') ? $this->Html->link($cmsPageTranslation->cms_page->id, ['controller' => 'CmsPage', 'action' => 'view', $cmsPageTranslation->cms_page->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($cmsPageTranslation->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Meta Title') ?></th>
            <td><?= h($cmsPageTranslation->meta_title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Meta Keywords') ?></th>
            <td><?= h($cmsPageTranslation->meta_keywords) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Meta Description') ?></th>
            <td><?= h($cmsPageTranslation->meta_description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lang') ?></th>
            <td><?= h($cmsPageTranslation->lang) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cmsPageTranslation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($cmsPageTranslation->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($cmsPageTranslation->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($cmsPageTranslation->updated_at) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($cmsPageTranslation->description)); ?>
    </div>
</div>
