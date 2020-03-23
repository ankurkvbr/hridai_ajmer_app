<?php
/**
  * @var \App\View\AppView $this
  */
?>
<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?//= __('Actions') ?></li>
        <li><? //$this->Html->link(__('New Cms Page Translation'), ['action' => 'add']) ?></li>
        <li><?//$this->Html->link(__('List Cms Page'), ['controller' => 'CmsPage', 'action' => 'index']) ?></li>
        <li><? //$this->Html->link(__('New Cms Page'), ['controller' => 'CmsPage', 'action' => 'add']) ?></li>
    </ul>
</nav>-->

<section class="content-header">
    <h1><?= __('Cms Page Translation') ?></h1>
    <?php $this->Html->addCrumb(__('User Management'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('List'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?= $this->Html->getCrumbList(
        ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false],
        ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    ); ?>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
			 <div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col"><?= $this->Paginator->sort('id') ?></th>
							<th scope="col"><?= $this->Paginator->sort('cms_page_id') ?></th>
							<th scope="col"><?= $this->Paginator->sort('name') ?></th>
							<th scope="col"><?= $this->Paginator->sort('meta_title') ?></th>
							<th scope="col"><?= $this->Paginator->sort('meta_keywords') ?></th>
							<th scope="col"><?= $this->Paginator->sort('meta_description') ?></th>
							<th scope="col"><?= $this->Paginator->sort('lang') ?></th>
							<th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
							<th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
							<th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						 <?php foreach ($cmsPageTranslation as $cmsPageTranslation): ?>
							<tr>
								<td><?= $this->Number->format($cmsPageTranslation->id) ?></td>
								<td><?= $cmsPageTranslation->has('cms_page') ? $this->Html->link($cmsPageTranslation->cms_page->id, ['controller' => 'CmsPage', 'action' => 'view', $cmsPageTranslation->cms_page->id]) : '' ?></td>
								<td><?= h($cmsPageTranslation->name) ?></td>
								<td><?= h($cmsPageTranslation->meta_title) ?></td>
								<td><?= h($cmsPageTranslation->meta_keywords) ?></td>
								<td><?= h($cmsPageTranslation->meta_description) ?></td>
								<td><?= h($cmsPageTranslation->lang) ?></td>
								<td><?= $this->Number->format($cmsPageTranslation->created_by) ?></td>
								<td><?= h($cmsPageTranslation->created_at) ?></td>
								<td><?= h($cmsPageTranslation->updated_at) ?></td>
								<td class="actions">
									<?= $this->Html->link(__('View'), ['action' => 'view', $cmsPageTranslation->id]) ?>
									<?= $this->Html->link(__('Edit'), ['action' => 'edit', $cmsPageTranslation->id]) ?>
									<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cmsPageTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cmsPageTranslation->id)]) ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
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
            <!-- /.box -->
        </div>
    </div>
</section>



<!--<div class="cmsPageTranslation index large-9 medium-8 columns content">
    <h3><?//= __('Cms Page Translation') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><? //$this->Paginator->sort('id') ?></th>
                <th scope="col"><?// $this->Paginator->sort('cms_page_id') ?></th>
                <th scope="col"><?// $this->Paginator->sort('name') ?></th>
                <th scope="col"><?// $this->Paginator->sort('meta_title') ?></th>
                <th scope="col"><?// $this->Paginator->sort('meta_keywords') ?></th>
                <th scope="col"><? //$this->Paginator->sort('meta_description') ?></th>
                <th scope="col"><?// $this->Paginator->sort('lang') ?></th>
                <th scope="col"><?// $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?// $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?// $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?// __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php //foreach ($cmsPageTranslation as $cmsPageTranslation): ?>
            <tr>
                <td><? //$this->Number->format($cmsPageTranslation->id) ?></td>
                <td><?// $cmsPageTranslation->has('cms_page') ? $this->Html->link($cmsPageTranslation->cms_page->id, ['controller' => 'CmsPage', 'action' => 'view', $cmsPageTranslation->cms_page->id]) : '' ?></td>
                <td><? //h($cmsPageTranslation->name) ?></td>
                <td><? //h($cmsPageTranslation->meta_title) ?></td>
                <td><?// h($cmsPageTranslation->meta_keywords) ?></td>
                <td><?// h($cmsPageTranslation->meta_description) ?></td>
                <td><?// h($cmsPageTranslation->lang) ?></td>
                <td><?// $this->Number->format($cmsPageTranslation->created_by) ?></td>
                <td><?// h($cmsPageTranslation->created_at) ?></td>
                <td><?// h($cmsPageTranslation->updated_at) ?></td>
                <td class="actions">
                    <? //$this->Html->link(__('View'), ['action' => 'view', $cmsPageTranslation->id]) ?>
                    <? //$this->Html->link(__('Edit'), ['action' => 'edit', $cmsPageTranslation->id]) ?>
                    <? //$this->Form->postLink(__('Delete'), ['action' => 'delete', $cmsPageTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cmsPageTranslation->id)]) ?>
                </td>
            </tr>
            <?php //endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <? //$this->Paginator->first('<< ' . __('first')) ?>
            <? //$this->Paginator->prev('< ' . __('previous')) ?>
            <? //$this->Paginator->numbers() ?>
            <?// $this->Paginator->next(__('next') . ' >') ?>
            <?// $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><? //$this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>-->




