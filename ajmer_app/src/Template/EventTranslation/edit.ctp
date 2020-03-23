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
                ['action' => 'delete', $eventTranslation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $eventTranslation->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Event Translation'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="eventTranslation form large-9 medium-8 columns content">
    <?= $this->Form->create($eventTranslation) ?>
    <fieldset>
        <legend><?= __('Edit Event Translation') ?></legend>
        <?php
            echo $this->Form->input('locale');
            echo $this->Form->input('model');
            echo $this->Form->input('foreign_key');
            echo $this->Form->input('field');
            echo $this->Form->input('content');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
