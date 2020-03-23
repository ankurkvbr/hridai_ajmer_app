<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cmsPageTranslation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cmsPageTranslation->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Cms Page Translation'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cms Page'), ['controller' => 'CmsPage', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cms Page'), ['controller' => 'CmsPage', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cmsPageTranslation form large-9 medium-8 columns content">
    <?= $this->Form->create($cmsPageTranslation) ?>
    <fieldset>
        <legend><?= __('Edit Cms Page Translation') ?></legend>
        <?php
            echo $this->Form->input('cms_page_id', ['options' => $cmsPage]);
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            echo $this->Form->input('meta_title');
            echo $this->Form->input('meta_keywords');
            echo $this->Form->input('meta_description');
            echo $this->Form->input('lang');
            echo $this->Form->input('created_by');
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
