<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php $authUser = $this->request->session()->read('Auth.User'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= __('User List') ?></h1>
    <?php $this->Html->addCrumb(__('User Management'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('User List'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?= $this->Html->getCrumbList(
        ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false],
        ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    ); ?>
</section>

<section class="content">
    <div class="row searchLag">
            <div class="col-sm-9" style="padding-bottom:10px">
                    <?= $this->Form->create(NULL,['type' => 'get','class'=>['form-inline']]) ?>
                            <div class="form-group">
                                    <?= $this->Form->input('search',[
                               'id'=>'search',
                               'label'=>false,
                               'placeholder' => h('Search by Name'),
                               'value' => (!empty($this->request->query['search']))? $this->request->query['search']:''
                                    ]);?>
                                <?= $this->Form->input('search_email',[
                               'id'=>'search_email',
                               'label'=>false,
                               'placeholder' => h('Search by Email'),
                               'value' => (!empty($this->request->query['search_email']))? $this->request->query['search_email']:''
                                    ]);?>
                                <?= $this->Form->input('search_mobile',[
                               'id'=>'search_mobile',
                               'label'=>false,
                               'placeholder' => h('Search by Mobile'),
                               'value' => (!empty($this->request->query['search_mobile']))? $this->request->query['search_mobile']:''
                                    ]);?>
                            </div>
                            <?= $this->Form->button(__('Filter')) ?>
                            <?= $this->Html->link('Reset',array('controller' => 'Users', 'action' => 'index'),['type' => 'get','class'=>['btn btn-success']]); ?>
                            <?= $this->Form->end() ?>
            </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
			 <div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<thead>
						<tr>
                                                    <th scope="col"><?= 'Sr. No.' ?></th>							
							<th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
							<th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
							 
							<th scope="col"><?= $this->Paginator->sort('email') ?></th>
							
							
							<th scope="col"><?= $this->Paginator->sort('mobile_no') ?></th>
							<th scope="col"><?= $this->Paginator->sort('Date of birth') ?></th>
							<th scope="col"><?= $this->Paginator->sort('postal_code') ?></th>
							
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
                                                    if($this->Paginator->param('page') > 1){
                                                            $sr_no = ($this->Paginator->param('perPage')*($this->Paginator->param('page')-1))+1;
                                                    } else {
                                                            $sr_no = 1;
                                                    }
                                                foreach ($users as $user):
                                                ?>
						<tr>
                                                        <td><?= $sr_no ?></td>							
							<td><?= h($user->first_name) ?></td>
							<td><?= h($user->last_name) ?></td>
							
							<td><?= h($user->email) ?></td>
							
							
							<td><?= $user->mobile_no ?></td>
							<td><?= ($user->dob && strtotime($user->dob) > 0) ? h( date("d/m/Y", strtotime($user->dob))) : '' ?></td>
							<td><?= h($user->postal_code) ?></td>
							<!--<td class="actions">
								<?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
								<?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
								<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
							</td>-->
							 <td class="textCenter actions">
                                    <?php //$this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $user->id], ['class' => 'btn btn-sm text-info', 'escape' => false,'rel'=>'tooltip','data-placement'=>'top', 'title'=>'View','title'=>'View','data-toggle'=>'tooltip']) ?>
                                                             
                                    <?= $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $user->id], ['class' => 'btn btn-sm text-success', 'escape' => false,'rel'=>'tooltip','data-placement'=>'top', 'title'=>'Edit','data-toggle'=>'tooltip']) ?>
                                    <?= $this->Form->postLink('<i class="fa fa-remove"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete this record?', $user->id), 'class' => 'btn btn-sm text-danger', 'escape' => false,'rel'=>'tooltip','data-placement'=>'top', 'title'=>'Delete','data-toggle'=>'tooltip']) ?>
                                </td>
						</tr>
						<?php
                                                    $sr_no++;
                                                    endforeach; ?>
					</tbody>
				</table>
			</div>
               <?php if($this->Paginator->params()["pageCount"]==0){
		echo 'No Record Found';
	}else{?> 
		<div class="pull-left pagingCount">
		<p><?php echo $this->Paginator->counter('Page ' . $this->Paginator->params()["page"] . ' of ' . $this->Paginator->params()["pageCount"] . ', showing ' . $this->Paginator->params()["current"] . ' records out of
	' . $this->Paginator->params()["count"] . ' total');}
		?></p>
		</div>
		
			<div class="paginator pull-right">
			<ul class="pagination">
            <?php echo $this->Paginator->first('<< ' . __('first')) ?>
            <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
            <?php echo $this->Paginator->numbers() ?>
            <?php echo $this->Paginator->next(__('next') . ' >') ?>
            <?php echo $this->Paginator->last(__('last') . ' >>') ?>
			</ul>
			<!--<p><?php echo $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>-->
			</div>
                
                
			</div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->

