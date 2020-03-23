<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Crafts & Foods'), ['action' => 'edit', $craftfood->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Crafts & Foods'), ['action' => 'delete', $craftfood->id], ['confirm' => __('Are you sure you want to delete # {0}?', $craftfood->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Crafts & Foods'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Crafts & Foods'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Crafts & Foods Title Translation'), ['controller' => 'MonumentsGardens_title_translation', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Crafts & Foods Title Translation'), ['controller' => 'MonumentsGardens_title_translation', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Crafts & Foods Description Translation'), ['controller' => 'MonumentsGardens_description_translation', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Crafts & Foods Description Translation'), ['controller' => 'MonumentsGardens_description_translation', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Crafts & Foods Translation'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Crafts & Foods Translation'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Crafts & Foods Images'), ['controller' => 'MonumentsGardensImages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Crafts & Foods Image'), ['controller' => 'MonumentsGardensImages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monument Rating'), ['controller' => 'MonumentRating', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monument Rating'), ['controller' => 'MonumentRating', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monument Review'), ['controller' => 'MonumentReview', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monument Review'), ['controller' => 'MonumentReview', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="monumentsGardens view large-9 medium-8 columns content">
    <h3><?= h($craftfood->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($craftfood->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $craftfood->has('state') ? $this->Html->link($craftfood->state->name, ['controller' => 'States', 'action' => 'view', $craftfood->state->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $craftfood->has('city') ? $this->Html->link($craftfood->city->name, ['controller' => 'Cities', 'action' => 'view', $craftfood->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= h($craftfood->latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= h($craftfood->longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Crafts & Foods Title Translation') ?></th>
            <td><?= $craftfood->has('title_translation') ? $this->Html->link($craftfood->title_translation->id, ['controller' => 'MonumentsGardens_title_translation', 'action' => 'view', $craftfood->title_translation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Crafts & Foods Description Translation') ?></th>
            <td><?= $craftfood->has('description_translation') ? $this->Html->link($craftfood->description_translation->id, ['controller' => 'MonumentsGardens_description_translation', 'action' => 'view', $craftfood->description_translation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($craftfood->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($craftfood->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($craftfood->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $craftfood->category ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $craftfood->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($craftfood->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($craftfood->address)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Crafts & Foods Translation') ?></h4>
        <?php if (!empty($craftfood->_i18n)): ?>
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
            <?php foreach ($craftfood->_i18n as $craftfoodsTranslation): ?>
            <tr>
                <td><?= h($craftfoodsTranslation->id) ?></td>
                <td><?= h($craftfoodsTranslation->locale) ?></td>
                <td><?= h($craftfoodsTranslation->model) ?></td>
                <td><?= h($craftfoodsTranslation->foreign_key) ?></td>
                <td><?= h($craftfoodsTranslation->field) ?></td>
                <td><?= h($craftfoodsTranslation->content) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'view', $craftfoodsTranslation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'edit', $craftfoodsTranslation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'delete', $craftfoodsTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $craftfoodsTranslation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Crafts & Foods Images') ?></h4>
        <?php if (!empty($craftfood->craft_food_images)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Monument Id') ?></th>
                <th scope="col"><?= __('Image') ?></th>
                <th scope="col"><?= __('Default') ?></th>
                <th scope="col"><?= __('Is Active') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($craftfood->craft_food_images as $craftfoodsImages): ?>
            <tr>
                <td><?= h($craftfoodsImages->id) ?></td>
                <td><?= h($craftfoodsImages->monument_id) ?></td>
                <td><?= h($craftfoodsImages->image) ?></td>
                <td><?= h($craftfoodsImages->default) ?></td>
                <td><?= h($craftfoodsImages->is_active) ?></td>
                <td><?= h($craftfoodsImages->created_at) ?></td>
                <td><?= h($craftfoodsImages->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MonumentsGardensImages', 'action' => 'view', $craftfoodsImages->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MonumentsGardensImages', 'action' => 'edit', $craftfoodsImages->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MonumentsGardensImages', 'action' => 'delete', $craftfoodsImages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $craftfoodsImages->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Crafts & Foods Translation') ?></h4>
        <?php if (!empty($craftfood->craft_food_translation)): ?>
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
            <?php foreach ($craftfood->craft_food_translation as $craftfoodsTranslation): ?>
            <tr>
                <td><?= h($craftfoodsTranslation->id) ?></td>
                <td><?= h($craftfoodsTranslation->locale) ?></td>
                <td><?= h($craftfoodsTranslation->model) ?></td>
                <td><?= h($craftfoodsTranslation->foreign_key) ?></td>
                <td><?= h($craftfoodsTranslation->field) ?></td>
                <td><?= h($craftfoodsTranslation->content) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'view', $craftfoodsTranslation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'edit', $craftfoodsTranslation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'delete', $craftfoodsTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $craftfoodsTranslation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
