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
                ['action' => 'delete', $eventImage->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $eventImage->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Event Images'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Event'), ['controller' => 'Event', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Event', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="eventImages form large-9 medium-8 columns content">
    <?= $this->Form->create($eventImage) ?>
    <fieldset>
        <legend><?= __('Edit Event Image') ?></legend>
        <?php
            echo $this->Form->input('event_id', ['options' => $event]);
            echo $this->Form->input('image');
            echo $this->Form->input('default');
            echo $this->Form->input('is_active');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
