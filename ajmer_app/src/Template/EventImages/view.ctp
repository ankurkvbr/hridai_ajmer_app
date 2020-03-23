<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Event Image'), ['action' => 'edit', $eventImage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Event Image'), ['action' => 'delete', $eventImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventImage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Event Images'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event Image'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Event'), ['controller' => 'Event', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Event', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="eventImages view large-9 medium-8 columns content">
    <h3><?= h($eventImage->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Event') ?></th>
            <td><?= $eventImage->has('event') ? $this->Html->link($eventImage->event->id, ['controller' => 'Event', 'action' => 'view', $eventImage->event->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image') ?></th>
            <td><?= h($eventImage->image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($eventImage->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $this->Number->format($eventImage->is_active) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Default') ?></h4>
        <?= $this->Text->autoParagraph(h($eventImage->default)); ?>
    </div>
</div>
