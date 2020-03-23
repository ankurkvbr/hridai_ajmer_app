<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Event'), ['action' => 'edit', $event->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Event'), ['action' => 'delete', $event->id], ['confirm' => __('Are you sure you want to delete # {0}?', $event->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Event'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Event Event Name Translation'), ['controller' => 'Event_event_name_translation', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event Event Name Translation'), ['controller' => 'Event_event_name_translation', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Event Event Description Translation'), ['controller' => 'Event_event_description_translation', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event Event Description Translation'), ['controller' => 'Event_event_description_translation', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Event Translation'), ['controller' => 'EventTranslation', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event Translation'), ['controller' => 'EventTranslation', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Event Images'), ['controller' => 'EventImages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event Image'), ['controller' => 'EventImages', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="event view large-9 medium-8 columns content">
    <h3><?= h($event->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Event Name') ?></th>
            <td><?= h($event->event_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $event->has('state') ? $this->Html->link($event->state->name, ['controller' => 'States', 'action' => 'view', $event->state->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Event Event Name Translation') ?></th>
            <td><?= $event->has('event_name_translation') ? $this->Html->link($event->event_name_translation->id, ['controller' => 'Event_event_name_translation', 'action' => 'view', $event->event_name_translation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Event Event Description Translation') ?></th>
            <td><?= $event->has('event_description_translation') ? $this->Html->link($event->event_description_translation->id, ['controller' => 'Event_event_description_translation', 'action' => 'view', $event->event_description_translation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($event->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City Id') ?></th>
            <td><?= $this->Number->format($event->city_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Even Date Time') ?></th>
            <td><?= h($event->even_date_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($event->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($event->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $event->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Event Description') ?></h4>
        <?= $this->Text->autoParagraph(h($event->event_description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Event Translation') ?></h4>
        <?php if (!empty($event->_i18n)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Locale') ?></th>
                <th scope="col"><?= __('Model') ?></th>
                <th scope="col"><?= __('Foreign Key') ?></th>
                <th scope="col"><?= __('Field') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($event->_i18n as $eventTranslation): ?>
            <tr>
                <td><?= h($eventTranslation->id) ?></td>
                <td><?= h($eventTranslation->locale) ?></td>
                <td><?= h($eventTranslation->model) ?></td>
                <td><?= h($eventTranslation->foreign_key) ?></td>
                <td><?= h($eventTranslation->field) ?></td>
                <td><?= h($eventTranslation->content) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EventTranslation', 'action' => 'view', $eventTranslation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EventTranslation', 'action' => 'edit', $eventTranslation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EventTranslation', 'action' => 'delete', $eventTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventTranslation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Event Images') ?></h4>
        <?php if (!empty($event->event_images)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Event Id') ?></th>
                <th scope="col"><?= __('Image') ?></th>
                <th scope="col"><?= __('Default') ?></th>
                <th scope="col"><?= __('Is Active') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($event->event_images as $eventImages): ?>
            <tr>
                <td><?= h($eventImages->id) ?></td>
                <td><?= h($eventImages->event_id) ?></td>
                <td><?= h($eventImages->image) ?></td>
                <td><?= h($eventImages->default) ?></td>
                <td><?= h($eventImages->is_active) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EventImages', 'action' => 'view', $eventImages->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EventImages', 'action' => 'edit', $eventImages->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EventImages', 'action' => 'delete', $eventImages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventImages->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
