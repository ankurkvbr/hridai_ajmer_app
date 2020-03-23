<?php
/**
  * @var \App\View\AppView $this
  */
?>
<section class="content-header">
    <?php if($this->request->params['action'] == 'myProfile'){ ?>
        <h1><?php  echo __('Cms View') ?></h1>
        <?php //$this->Html->addCrumb(__('User Management'), ['action' => 'index']); ?>
        <?php $this->Html->addCrumb(__('My Profile'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php }else{ ?>
        <h1><?php echo __('CmsPage:').' '.h($cmsPage->name)  ?></h1>
        <?php $this->Html->addCrumb(__('CMS'), ['action' => 'index']); ?>
        <?php $this->Html->addCrumb(__('View CMS Translation'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php } ?>
    <?php  echo $this->Html->getCrumbList(
        ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false],
        ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    ); ?>
</section>

<section class="content">
    <div class="row">
        
        <div class="col-xs-12">
            
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?php  echo __('Name') ?></strong></th>
                                    <td><?php  echo h($cmsPage->name) ?></td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?php  echo __('Description') ?></strong></th>
                                    <td><?php  echo h($cmsPage->description) ?></td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?php  echo __('Meta Title') ?></strong></th>
                                    <td><?php  echo h($cmsPage->meta_title) ?></td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?php  echo __('Meta Keywords') ?></strong></th>
                                    <td><?php  echo $cmsPage->meta_keywords ?></td>
                                </tr>
                            </div> 
							<div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?php  echo __('Meta Description') ?></strong></th>
                                    <td><?php  echo $cmsPage->meta_description ?></td>
                                </tr>
                            </div> 
                            <div class="form-group">
                                <tr>
                                    <th scope="row"><strong><?php  echo __('Is Active') ?></strong></th>
                                    <td><?php  echo $cmsPage->is_active ? __('Yes') : __('No'); ?></td>
                                </tr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
        
    </div>
  
</section>


<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php  echo __('Actions') ?></li>
        <li><?php  echo $this->Html->link(__('Edit Cms Page'), ['action' => 'edit', $cmsPage->id]) ?> </li>
        <li><?php  echo $this->Form->postLink(__('Delete Cms Page'), ['action' => 'delete', $cmsPage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cmsPage->id)]) ?> </li>
        <li><?php  echo $this->Html->link(__('List Cms Page'), ['action' => 'index']) ?> </li>
        <li><?php  echo $this->Html->link(__('New Cms Page'), ['action' => 'add']) ?> </li>
        <li><?php  echo $this->Html->link(__('List Cms Page Translation'), ['controller' => 'CmsPageTranslation', 'action' => 'index']) ?> </li>
        <li><?php  echo $this->Html->link(__('New Cms Page Translation'), ['controller' => 'CmsPageTranslation', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cmsPage view large-9 medium-8 columns content">
    <h3><?php  echo h($cmsPage->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?php  echo __('Id') ?></th>
            <td><?php  echo $this->Number->format($cmsPage->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php  echo __('Created At') ?></th>
            <td><?php  echo h($cmsPage->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php  echo __('Updated At') ?></th>
            <td><?php  echo h($cmsPage->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php  echo __('Is Active') ?></th>
            <td><?php  echo $cmsPage->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?php  echo __('Related Cms Page Translation') ?></h4>
        <?php if (!empty($cmsPage->cms_page_translation)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?php  echo __('Id') ?></th>
                <th scope="col"><?php  echo __('Cms Page Id') ?></th>
                <th scope="col"><?php  echo __('Name') ?></th>
                <th scope="col"><?php  echo __('Description') ?></th>
                <th scope="col"><?php  echo __('Meta Title') ?></th>
                <th scope="col"><?php  echo __('Meta Keywords') ?></th>
                <th scope="col"><?php  echo __('Meta Description') ?></th>
                <th scope="col"><?php  echo __('Lang') ?></th>
                <th scope="col"><?php  echo __('Is Active') ?></th>
                <th scope="col"><?php  echo __('Created By') ?></th>
                <th scope="col"><?php  echo __('Created At') ?></th>
                <th scope="col"><?php  echo __('Updated At') ?></th>
                <th scope="col" class="actions"><?php  echo __('Actions') ?></th>
            </tr>
            <?php foreach ($cmsPage->cms_page_translation as $cmsPageTranslation): ?>
            <tr>
                <td><?php  echo h($cmsPageTranslation->id) ?></td>
                <td><?php  echo h($cmsPageTranslation->cms_page_id) ?></td>
                <td><?php  echo h($cmsPageTranslation->name) ?></td>
                <td><?php  echo h($cmsPageTranslation->description) ?></td>
                <td><?php  echo h($cmsPageTranslation->meta_title) ?></td>
                <td><?php  echo h($cmsPageTranslation->meta_keywords) ?></td>
                <td><?php  echo h($cmsPageTranslation->meta_description) ?></td>
                <td><?php  echo h($cmsPageTranslation->lang) ?></td>
                <td><?php  echo h($cmsPageTranslation->is_active) ?></td>
                <td><?php  echo h($cmsPageTranslation->created_by) ?></td>
                <td><?php  echo h($cmsPageTranslation->created_at) ?></td>
                <td><?php  echo h($cmsPageTranslation->updated_at) ?></td>
                <td class="actions">
                    <?php  echo $this->Html->link(__('View'), ['controller' => 'CmsPageTranslation', 'action' => 'view', $cmsPageTranslation->id]) ?>
                    <?php  echo $this->Html->link(__('Edit'), ['controller' => 'CmsPageTranslation', 'action' => 'edit', $cmsPageTranslation->id]) ?>
                    <?php  echo $this->Form->postLink(__('Delete'), ['controller' => 'CmsPageTranslation', 'action' => 'delete', $cmsPageTranslation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cmsPageTranslation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>-->
