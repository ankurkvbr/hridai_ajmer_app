<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php $authfeedbackdetail = $this->request->session()->read('Auth.feedback'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= __('Feedback List') ?></h1>
    <?php $this->Html->addCrumb(__('Feedback'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('Feedback List'), 'javascript:void(0);', ['class' => 'active']); ?>
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
			   'placeholder' => h('Search by Description'),
			   'value' => (!empty($this->request->query['search']))? $this->request->query['search']:''
					]);?>    
			</div>
			<?= $this->Form->button(__('Filter')) ?>
			<?= $this->Html->link('Reset',array('controller' => 'feedback', 'action' => 'index'),['type' => 'get','class'=>['btn btn-success']]); ?>
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
								<th scope="col"><?php echo 'Users';//echo $this->Paginator->sort('user_id', __('Users')) ?></th>
								<th scope="col"><?= $this->Paginator->sort('feedback_for_id') ?></th>
								 
								<th scope="col"><?= $this->Paginator->sort('feedback_category_id') ?></th>
								
								<th scope="col"><?= $this->Paginator->sort('description') ?></th>
								<th scope="col"><?= $this->Paginator->sort('rating') ?></th>
								<th scope="col" class="actions"><?php echo __('Actions') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							if($this->Paginator->param('page') > 1){
									$sr_no = ($this->Paginator->param('perPage')*($this->Paginator->param('page')-1))+1;
							} else {
									$sr_no = 1;
							}
							foreach ($feedback as $feedbackdetail):
								//echo '<pre>';print_r($feedbackdetail);exit;
							?>
							<tr>
								<td><?= $sr_no ?></td>							
								<td><?= $feedbackdetail->has('user') ? $feedbackdetail->user->first_name .' '.$feedbackdetail->user->last_name : '';  ?></td>
								<td>
								<?php 
									if($feedbackdetail->feedback_for_id == 1){
										echo h('Ajmer Visit Experience');
									}else if($feedbackdetail->feedback_for_id == 2){
										echo h('App. Experience');
									}
								?>
								</td>
								<td>
									<?php
									if($feedbackdetail->feedback_category_id == 0){
										echo h('Suggestion');
									}else if($feedbackdetail->feedback_category_id == 1){
										echo h('Compaint');
									}else if($feedbackdetail->feedback_category_id == 2){
										echo h('Others');
									}
										?>
								</td>
								<td><?= $feedbackdetail->description ?></td>
								<td><?= $feedbackdetail->rating ?></td>
								<!--<td class="actions">
									<?= $this->Html->link(__('View'), ['action' => 'view', $feedbackdetail->id]) ?>
									<?= $this->Html->link(__('Edit'), ['action' => 'edit', $feedbackdetail->id]) ?>
									<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $feedbackdetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedbackdetail->id)]) ?>
								</td>-->
								<td class="textCenter actions">
									<?php echo $this->Form->postLink('<i class="fa fa-remove"></i>', ['action' => 'delete', $feedbackdetail->id], ['confirm' => __('Are you sure you want to delete this record ?'), 'class' => 'btn btn-sm text-danger', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delete', 'data-toggle' => 'tooltip']); ?>
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
				} else{?> 
					<div class="pull-left pagingCount">
						<p><?php echo $this->Paginator->counter('Page ' . $this->Paginator->params()["page"] . ' of ' . $this->Paginator->params()["pageCount"] . ', showing ' . $this->Paginator->params()["current"] . ' records out of
					' . $this->Paginator->params()["count"] . ' total');
					} ?></p>
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

