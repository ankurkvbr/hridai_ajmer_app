<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Event Translation'), ['action' => 'edit', $eventTranslation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Event Translation'), ['action' => 'delete', $eventTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventTranslation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Event Translation'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event Translation'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="eventTranslation view large-9 medium-8 columns content">
    <h3><?= h($eventTranslation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Locale') ?></th>
            <td><?= h($eventTranslation->locale) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Model') ?></th>
            <td><?= h($eventTranslation->model) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Field') ?></th>
            <td><?= h($eventTranslation->field) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($eventTranslation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Foreign Key') ?></th>
            <td><?= $this->Number->format($eventTranslation->foreign_key) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Content') ?></h4>
        <?= $this->Text->autoParagraph(h($eventTranslation->content)); ?>
    </div>
</div>
