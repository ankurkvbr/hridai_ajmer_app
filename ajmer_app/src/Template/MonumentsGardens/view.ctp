<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Monuments Garden'), ['action' => 'edit', $monumentsGarden->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Monuments Garden'), ['action' => 'delete', $monumentsGarden->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monumentsGarden->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Monuments Gardens'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monuments Garden'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monuments Gardens Title Translation'), ['controller' => 'MonumentsGardens_title_translation', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monuments Gardens Title Translation'), ['controller' => 'MonumentsGardens_title_translation', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monuments Gardens Description Translation'), ['controller' => 'MonumentsGardens_description_translation', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monuments Gardens Description Translation'), ['controller' => 'MonumentsGardens_description_translation', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monuments Gardens Translation'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monuments Gardens Translation'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monuments Gardens Images'), ['controller' => 'MonumentsGardensImages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monuments Gardens Image'), ['controller' => 'MonumentsGardensImages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monument Rating'), ['controller' => 'MonumentRating', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monument Rating'), ['controller' => 'MonumentRating', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monument Review'), ['controller' => 'MonumentReview', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monument Review'), ['controller' => 'MonumentReview', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="monumentsGardens view large-9 medium-8 columns content">
    <h3><?= h($monumentsGarden->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($monumentsGarden->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $monumentsGarden->has('state') ? $this->Html->link($monumentsGarden->state->name, ['controller' => 'States', 'action' => 'view', $monumentsGarden->state->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $monumentsGarden->has('city') ? $this->Html->link($monumentsGarden->city->name, ['controller' => 'Cities', 'action' => 'view', $monumentsGarden->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= h($monumentsGarden->latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= h($monumentsGarden->longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monuments Gardens Title Translation') ?></th>
            <td><?= $monumentsGarden->has('title_translation') ? $this->Html->link($monumentsGarden->title_translation->id, ['controller' => 'MonumentsGardens_title_translation', 'action' => 'view', $monumentsGarden->title_translation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monuments Gardens Description Translation') ?></th>
            <td><?= $monumentsGarden->has('description_translation') ? $this->Html->link($monumentsGarden->description_translation->id, ['controller' => 'MonumentsGardens_description_translation', 'action' => 'view', $monumentsGarden->description_translation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($monumentsGarden->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($monumentsGarden->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($monumentsGarden->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $monumentsGarden->category ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $monumentsGarden->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($monumentsGarden->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($monumentsGarden->address)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Monuments Gardens Translation') ?></h4>
        <?php if (!empty($monumentsGarden->_i18n)): ?>
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
            <?php foreach ($monumentsGarden->_i18n as $monumentsGardensTranslation): ?>
            <tr>
                <td><?= h($monumentsGardensTranslation->id) ?></td>
                <td><?= h($monumentsGardensTranslation->locale) ?></td>
                <td><?= h($monumentsGardensTranslation->model) ?></td>
                <td><?= h($monumentsGardensTranslation->foreign_key) ?></td>
                <td><?= h($monumentsGardensTranslation->field) ?></td>
                <td><?= h($monumentsGardensTranslation->content) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'view', $monumentsGardensTranslation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'edit', $monumentsGardensTranslation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'delete', $monumentsGardensTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monumentsGardensTranslation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Monuments Gardens Images') ?></h4>
        <?php if (!empty($monumentsGarden->monuments_gardens_images)): ?>
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
            <?php foreach ($monumentsGarden->monuments_gardens_images as $monumentsGardensImages): ?>
            <tr>
                <td><?= h($monumentsGardensImages->id) ?></td>
                <td><?= h($monumentsGardensImages->monument_id) ?></td>
                <td><?= h($monumentsGardensImages->image) ?></td>
                <td><?= h($monumentsGardensImages->default) ?></td>
                <td><?= h($monumentsGardensImages->is_active) ?></td>
                <td><?= h($monumentsGardensImages->created_at) ?></td>
                <td><?= h($monumentsGardensImages->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MonumentsGardensImages', 'action' => 'view', $monumentsGardensImages->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MonumentsGardensImages', 'action' => 'edit', $monumentsGardensImages->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MonumentsGardensImages', 'action' => 'delete', $monumentsGardensImages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monumentsGardensImages->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Monuments Gardens Translation') ?></h4>
        <?php if (!empty($monumentsGarden->monuments_gardens_translation)): ?>
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
            <?php foreach ($monumentsGarden->monuments_gardens_translation as $monumentsGardensTranslation): ?>
            <tr>
                <td><?= h($monumentsGardensTranslation->id) ?></td>
                <td><?= h($monumentsGardensTranslation->locale) ?></td>
                <td><?= h($monumentsGardensTranslation->model) ?></td>
                <td><?= h($monumentsGardensTranslation->foreign_key) ?></td>
                <td><?= h($monumentsGardensTranslation->field) ?></td>
                <td><?= h($monumentsGardensTranslation->content) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'view', $monumentsGardensTranslation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'edit', $monumentsGardensTranslation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MonumentsGardensTranslation', 'action' => 'delete', $monumentsGardensTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monumentsGardensTranslation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Monument Rating') ?></h4>
        <?php if (!empty($monumentsGarden->monument_rating)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Monument Id') ?></th>
                <th scope="col"><?= __('Rating') ?></th>
                <th scope="col"><?= __('Is Publish') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($monumentsGarden->monument_rating as $monumentRating): ?>
            <tr>
                <td><?= h($monumentRating->id) ?></td>
                <td><?= h($monumentRating->monument_id) ?></td>
                <td><?= h($monumentRating->rating) ?></td>
                <td><?= h($monumentRating->is_publish) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MonumentRating', 'action' => 'view', $monumentRating->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MonumentRating', 'action' => 'edit', $monumentRating->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MonumentRating', 'action' => 'delete', $monumentRating->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monumentRating->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Monument Review') ?></h4>
        <?php if (!empty($monumentsGarden->monument_review)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Monument Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Review') ?></th>
                <th scope="col"><?= __('Rating') ?></th>
                <th scope="col"><?= __('Is Publish') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($monumentsGarden->monument_review as $monumentReview): ?>
            <tr>
                <td><?= h($monumentReview->id) ?></td>
                <td><?= h($monumentReview->monument_id) ?></td>
                <td><?= h($monumentReview->user_id) ?></td>
                <td><?= h($monumentReview->title) ?></td>
                <td><?= h($monumentReview->review) ?></td>
                <td><?= h($monumentReview->rating) ?></td>
                <td><?= h($monumentReview->is_publish) ?></td>
                <td><?= h($monumentReview->created_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MonumentReview', 'action' => 'view', $monumentReview->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MonumentReview', 'action' => 'edit', $monumentReview->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MonumentReview', 'action' => 'delete', $monumentReview->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monumentReview->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
