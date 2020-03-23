<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Event Image'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Event'), ['controller' => 'Event', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Event', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="eventImages index large-9 medium-8 columns content">
    <h3><?= __('Event Images') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('event_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_active') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventImages as $eventImage): ?>
            <tr>
                <td><?= $this->Number->format($eventImage->id) ?></td>
                <td><?= $eventImage->has('event') ? $this->Html->link($eventImage->event->id, ['controller' => 'Event', 'action' => 'view', $eventImage->event->id]) : '' ?></td>
                <td><?= h($eventImage->image) ?></td>
                <td><?= $this->Number->format($eventImage->is_active) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $eventImage->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $eventImage->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $eventImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventImage->id)]) ?>
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
