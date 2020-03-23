<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php echo __('Actions') ?></li>
        <li><?php echo $this->Html->link(__('Edit Project'), ['action' => 'edit', $project->id]) ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Project'), ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]) ?> </li>
        <li><?php echo $this->Html->link(__('List Project'), ['action' => 'index']) ?> </li>
        <li><?php echo $this->Html->link(__('New Project'), ['action' => 'add']) ?> </li>
        <li><?php echo $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?php echo $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?php echo $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?php echo $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?php echo $this->Html->link(__('List Project Project Name Translation'), ['controller' => 'Project_project_name_translation', 'action' => 'index']) ?> </li>
        <li><?php echo $this->Html->link(__('New Project Project Name Translation'), ['controller' => 'Project_project_name_translation', 'action' => 'add']) ?> </li>
        <li><?php echo $this->Html->link(__('List Project Project Description Translation'), ['controller' => 'Project_project_description_translation', 'action' => 'index']) ?> </li>
        <li><?php echo $this->Html->link(__('New Project Project Description Translation'), ['controller' => 'Project_project_description_translation', 'action' => 'add']) ?> </li>
        <li><?php echo $this->Html->link(__('List Project Translation'), ['controller' => 'ProjectTranslation', 'action' => 'index']) ?> </li>
        <li><?php echo $this->Html->link(__('New Project Translation'), ['controller' => 'ProjectTranslation', 'action' => 'add']) ?> </li>
        <li><?php echo $this->Html->link(__('List Project Images'), ['controller' => 'ProjectImages', 'action' => 'index']) ?> </li>
        <li><?php echo $this->Html->link(__('New Project Image'), ['controller' => 'ProjectImages', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="project view large-9 medium-8 columns content">
    <h3><?php echo h($project->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?php echo __('Project Name') ?></th>
            <td><?php echo h($project->project_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __('State') ?></th>
            <td><?php echo $project->has('state') ? $this->Html->link($project->state->name, ['controller' => 'States', 'action' => 'view', $project->state->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __('City') ?></th>
            <td><?php echo $project->has('city') ? $this->Html->link($project->city->name, ['controller' => 'Cities', 'action' => 'view', $project->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __('Url') ?></th>
            <td><?php echo h($project->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __('Project Project Name Translation') ?></th>
            <td><?php echo $project->has('project_name_translation') ? $this->Html->link($project->project_name_translation->id, ['controller' => 'Project_project_name_translation', 'action' => 'view', $project->project_name_translation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __('Project Project Description Translation') ?></th>
            <td><?php echo $project->has('project_description_translation') ? $this->Html->link($project->project_description_translation->id, ['controller' => 'Project_project_description_translation', 'action' => 'view', $project->project_description_translation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __('Id') ?></th>
            <td><?php echo $this->Number->format($project->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __('Created At') ?></th>
            <td><?php echo h($project->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __('Updated At') ?></th>
            <td><?php echo h($project->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __('Is Active') ?></th>
            <td><?php echo $project->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?php echo __('Project Description') ?></h4>
        <?php echo $this->Text->autoParagraph(h($project->project_description)); ?>
    </div>
    <div class="related">
        <h4><?php echo __('Related Project Translation') ?></h4>
        <?php if (!empty($project->_i18n)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?php echo __('Id') ?></th>
                <th scope="col"><?php echo __('Locale') ?></th>
                <th scope="col"><?php echo __('Model') ?></th>
                <th scope="col"><?php echo __('Foreign Key') ?></th>
                <th scope="col"><?php echo __('Field') ?></th>
                <th scope="col"><?php echo __('Content') ?></th>
                <th scope="col" class="actions"><?php echo __('Actions') ?></th>
            </tr>
            <?php foreach ($project->_i18n as $projectTranslation): ?>
            <tr>
                <td><?php echo h($projectTranslation->id) ?></td>
                <td><?php echo h($projectTranslation->locale) ?></td>
                <td><?php echo h($projectTranslation->model) ?></td>
                <td><?php echo h($projectTranslation->foreign_key) ?></td>
                <td><?php echo h($projectTranslation->field) ?></td>
                <td><?php echo h($projectTranslation->content) ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), ['controller' => 'ProjectTranslation', 'action' => 'view', $projectTranslation->id]) ?>
                    <?php echo $this->Html->link(__('Edit'), ['controller' => 'ProjectTranslation', 'action' => 'edit', $projectTranslation->id]) ?>
                    <?php echo $this->Form->postLink(__('Delete'), ['controller' => 'ProjectTranslation', 'action' => 'delete', $projectTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectTranslation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?php echo __('Related Project Images') ?></h4>
        <?php if (!empty($project->project_images)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?php echo __('Id') ?></th>
                <th scope="col"><?php echo __('Project Id') ?></th>
                <th scope="col"><?php echo __('Image') ?></th>
                <th scope="col"><?php echo __('Default') ?></th>
                <th scope="col"><?php echo __('Is Active') ?></th>
                <th scope="col" class="actions"><?php echo __('Actions') ?></th>
            </tr>
            <?php foreach ($project->project_images as $projectImages): ?>
            <tr>
                <td><?php echo h($projectImages->id) ?></td>
                <td><?php echo h($projectImages->project_id) ?></td>
                <td><?php echo h($projectImages->image) ?></td>
                <td><?php echo h($projectImages->default) ?></td>
                <td><?php echo h($projectImages->is_active) ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), ['controller' => 'ProjectImages', 'action' => 'view', $projectImages->id]) ?>
                    <?php echo $this->Html->link(__('Edit'), ['controller' => 'ProjectImages', 'action' => 'edit', $projectImages->id]) ?>
                    <?php echo $this->Form->postLink(__('Delete'), ['controller' => 'ProjectImages', 'action' => 'delete', $projectImages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectImages->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?php echo __('Related Project Translation') ?></h4>
        <?php if (!empty($project->project_translation)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?php echo __('Id') ?></th>
                <th scope="col"><?php echo __('Locale') ?></th>
                <th scope="col"><?php echo __('Model') ?></th>
                <th scope="col"><?php echo __('Foreign Key') ?></th>
                <th scope="col"><?php echo __('Field') ?></th>
                <th scope="col"><?php echo __('Content') ?></th>
                <th scope="col" class="actions"><?php echo __('Actions') ?></th>
            </tr>
            <?php foreach ($project->project_translation as $projectTranslation): ?>
            <tr>
                <td><?php echo h($projectTranslation->id) ?></td>
                <td><?php echo h($projectTranslation->locale) ?></td>
                <td><?php echo h($projectTranslation->model) ?></td>
                <td><?php echo h($projectTranslation->foreign_key) ?></td>
                <td><?php echo h($projectTranslation->field) ?></td>
                <td><?php echo h($projectTranslation->content) ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), ['controller' => 'ProjectTranslation', 'action' => 'view', $projectTranslation->id]) ?>
                    <?php echo $this->Html->link(__('Edit'), ['controller' => 'ProjectTranslation', 'action' => 'edit', $projectTranslation->id]) ?>
                    <?php echo $this->Form->postLink(__('Delete'), ['controller' => 'ProjectTranslation', 'action' => 'delete', $projectTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectTranslation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
