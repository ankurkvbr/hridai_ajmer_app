<?php
/**
  * @var \App\View\AppView $this
  */
?>
<section class="content-header">
    <h1><?php  echo __('CMS Page List') ?></h1>
    <?php $this->Html->addCrumb(__('CMS'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('CMS Page List'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php  echo $this->Html->getCrumbList(
        ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false],
        ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    ); ?>
</section>
<section class="content">
<div class="row searchLag">
	<div class="col-sm-9">
		<?php  echo $this->Form->create(NULL,['type' => 'get','class'=>['form-inline']]) ?>
		<?php echo $this->Form->input('lang',['type'=>'hidden','id'=>'language','value' => $language]); ?>
			<div class="form-group">
				<?php  echo $this->Form->input('search',[
			   'id'=>'search',
			   'label'=>false,
			   'placeholder' => h('Search by Name'),
			   'value' => (!empty($this->request->query['search']))? $this->request->query['search']:''
				]);?>
			</div>
			<?php  echo $this->Form->button(__('Filter')) ?>
			<?php  echo $this->Html->link('Reset',array('controller' => 'CmsPage', 'action' => 'index'),['type' => 'get','class'=>['btn btn-success']]); ?>
			<?php  echo $this->Form->end() ?>
	</div>
	<div class="col-sm-3">
	<div class="form-group">
	<?php echo $this->Form->input('lang',array('options'=>[''=>'English','hi'=>'Hindi'],'label'=>false,'value' => $language)); ?>
    </div>
	</div>
</div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
			 <div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<thead>
						 <tr>
							<th scope="col"><?php  echo __('Sr. No.') ?></th>
							<th scope="col"><?php  echo $this->Paginator->sort('name',__('Name')) ?></th>
							<th scope="col"><?php  echo $this->Paginator->sort('meta_title',__('Meta Title')) ?></th>
							<th scope="col"><?php  echo $this->Paginator->sort('meta_keywords',__('Meta Keywords')) ?></th>
							<th scope="col"><?php //echo $this->Paginator->sort('meta_description') ?></th>
							<th scope="col"><?php //echo $this->Paginator->sort('created_by') ?></th>
							<th scope="col"><?php  echo $this->Paginator->sort('is_active',__('Is Active')) ?></th>
							<th scope="col"><?php  echo $this->Paginator->sort('created_at',__('Created Date')) ?></th>
							<th scope="col"><?php //echo $this->Paginator->sort('updated_at') ?></th>
							<th scope="col" class="actions"><?php  echo __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if($this->Paginator->param('page') > 1){
						     $sn_count = ($this->Paginator->param('perPage')*($this->Paginator->param('page')-1))+1;
					        } else {
									$sn_count = 1;
							}
							foreach ($cmsPage as $cmsPage):
								$cmsPage_created_at_AM = str_replace('पूर्वाह्न', 'AM',$cmsPage->created_at);
                                $cmsPage_created_at_PM = str_replace('अपराह्न', 'PM',$cmsPage->created_at);
                                $cmsPage_created_at = (strpos($cmsPage_created_at_PM,'PM')) ? $cmsPage_created_at_PM : $cmsPage_created_at_AM;
                                if($language == 'hi'){
                                    $asCreated_at = explode('-',$cmsPage_created_at);
                                    if(isset($asCreated_at[1]) && $asCreated_at[2]){
                                        $cmsPage_created_at = $asCreated_at[1].'/'.$asCreated_at[0].'/'.$asCreated_at[2];
                                    }                                    
                                }
										
										
							?>
							<tr>
								<td><?php  echo $this->Number->format($sn_count) ?></td>
								<td><?php  echo h($cmsPage->name) ?></td>
								<td><?php  echo h($cmsPage->meta_title) ?></td>
								<td><?php  echo h($cmsPage->meta_keywords) ?></td>
								<td><?php //echo h($cmsPage->meta_description) ?></td>
								<td><?php //echo $this->Number->format($cmsPage->created_by) ?></td>
								<td><?php  echo $cmsPage->is_active ? __('Yes') : __('No'); ?></td>
								   
								<td><?php  echo h(date('d/m/Y', strtotime($cmsPage_created_at))) ?></td>
								<td><?php //echo h($cmsPage->updated_at) ?></td>
								<td class="textCenter actions"><?php  echo $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', base64_encode($cmsPage->id),'?'=>['lang'=>$language]], ['class' => 'btn btn-sm text-success', 'escape' => false,'rel'=>'tooltip','data-placement'=>'top', 'title'=>'Edit','data-toggle'=>'tooltip']) ?>
								   <?php echo ($language != 'hi') ? $this->Form->postLink('<i class="fa fa-remove"></i>', ['action' => 'delete', $cmsPage->id], ['confirm' => __('Are you sure you want to delete this record?', $cmsPage->id), 'class' => 'btn btn-sm text-danger', 'escape' => false,'rel'=>'tooltip','data-placement'=>'top', 'title'=>'Delete','data-toggle'=>'tooltip']) : '' ; ?>
								</td>
							</tr>
							<?php $sn_count++;
							endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php if($this->Paginator->params()["pageCount"]==0){
				echo 'No Record Found';
			 }else{?>
			 <div class="pull-left pagingCount">
				<p><?php echo $this->Paginator->counter(
				'Page ' . $this->Paginator->params()["page"] . ' of ' . $this->Paginator->params()["pageCount"] . ', showing ' . $this->Paginator->params()["current"] . ' records out of
				' . $this->Paginator->params()["count"] . ' total');} ?>
				</p>
			 </div>
			<div class="paginator pull-right">
			<ul class="pagination">
				<?php  echo $this->Paginator->first('<< ' . __('first')) ?>
				<?php  echo $this->Paginator->prev('< ' . __('previous')) ?>
				<?php  echo $this->Paginator->numbers() ?>
				<?php  echo $this->Paginator->next(__('next') . ' >') ?>
				<?php  echo $this->Paginator->last(__('last') . ' >>') ?>
			</ul>
		   </div>
			</div>
		</div>
	</div>
</div>
</section>
<?php $this->start('scriptBotton'); ?>
<script> 
	 $(document).ready(function () {
		$("#lang").change(function(){
			window.location.href = '<?php  echo $this->Url->build(["action" => "index","?" => ["lang" => ""]]); ?>'+$(this).val();
		});
	});
</script>
<?php $this->end('scriptBotton'); ?>