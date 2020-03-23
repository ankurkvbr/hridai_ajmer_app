<!-- Content Header (Page header) -->
<section class="content-header">
<h1><?php echo __('Fairs & Festivals List') ?></h1>
<?php $this->Html->addCrumb(__('Fairs & Festivals'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('Fairs & Festivals List'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php echo $this->Html->getCrumbList(
        ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false],
        ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    );
?>
</section>
<section class="content">
<div class="row searchLag">
	<div class="col-sm-9">
	<?php echo $this->Form->create(NULL,['type' => 'get','class'=>['form-inline']]) ?>
		<?php echo $this->Form->input('lang',['type'=>'hidden','id'=>'language','value' => $language]); ?>
		<div class="form-group">
			<?php echo $this->Form->input('search',[
			   'id'=>'search',
			   'label'=>false,
			   'placeholder' => h('Search by Event'),
			   'value' => (!empty($this->request->query['search']))? $this->request->query['search']:''
			]);?>
		</div>
		<?php echo $this->Form->button(__('Filter')) ?>
		<?php echo $this->Html->link('Reset',array('controller' => 'Event', 'action' => 'index'),['type' => 'get','class'=>['btn btn-success']]); ?>
	<?php echo $this->Form->end() ?>
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
							<th scope="col"><?php echo __('Sr. No.') ?></th>
							<th scope="col"><?php echo $this->Paginator->sort('event_name',__('Name')) ?></th>
							<th scope="col"><?php echo $this->Paginator->sort('even_date_time',__('Date & Time')) ?></th>
							<!--<th scope="col"><?php echo $this->Paginator->sort('state_id',__('State')) ?></th>
							<th scope="col"><?php echo $this->Paginator->sort('cities_id',__('City')) ?></th>-->
							<th scope="col"><?php echo __('Image') ?></th>
							<th scope="col"><?php echo $this->Paginator->sort('is_active',__('Is Active')) ?></th>
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
					
					foreach ($event as $event): 
                                 
                                if($event->created_at){
                                    $event_created_at_AM = str_replace('पूर्वाह्न', 'AM',$event->even_date_time);
                                    $event_created_at_PM = str_replace('अपराह्न', 'PM',$event->even_date_time);
                                    $event_created_at = (strpos($event_created_at_PM,'PM')) ? $event_created_at_PM : $event_created_at_AM;
                                    if($language == 'hi'){
                                        $asCreated_at = explode('/',$event_created_at);
                                        if(isset($asCreated_at[1]) && $asCreated_at[2]){
                                            $event_created_at = $asCreated_at[1].'/'.$asCreated_at[0].'/'.$asCreated_at[2];
                                        }
                                                                                
                                    }
                                }
					?>
						<tr>
							<td><?php echo $this->Number->format($sr_no) ?></td>
							<td><?php echo h($event->event_name) ?></td>
							<td><?php echo ($event->even_date_time) ? h(date('d/m/Y H:i',strtotime($event_created_at))): '';?></td>
							<!--<td><?php echo $event->has('state') ? $event->state->name : ''; // $this->Html->link($event->state->name, ['controller' => 'States', 'action' => 'view', $event->state->id]) : '' ?></td>-->
							<!--<td><?php echo $event->has('city') ? $event->city->name: '';//$this->Html->link($event->city->name, ['controller' => 'Cities', 'action' => 'view', $event->city->id]) : '' ?></td>-->
							<td><img src="<?php echo 'resize/100x100/img/event/'.@$event->event_images[0]->image; ?>"/></td>
							<td><?php echo $event->is_active ? __('Yes') : __('No'); ?></td>
						   <!--<td class="actions">
								<?php echo $this->Html->link(__('View'), ['action' => 'view', $event->id]) ?>
								<?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $event->id]) ?>
								<?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $event->id], ['confirm' => __('Are you sure you want to delete # {0}?', $event->id)]) ?>
							</td>-->
							 <td class="textCenter actions">
								<?php echo $this->Html->link('<i class="fa fa-image"></i>', ['action' => 'viewimages', $event->id], ['class' => 'btn btn-sm text-success', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'List of images', 'data-toggle' => 'tooltip']) ?>
								<?php echo $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $event->id,'?'=>['lang'=>$language]], ['class' => 'btn btn-sm text-success', 'escape' => false,'rel'=>'tooltip','data-placement'=>'top', 'title'=>'Edit','data-toggle'=>'tooltip']) ?>
								<?php echo ($language != 'hi') ?  $this->Form->postLink('<i class="fa fa-remove"></i>', ['action' => 'delete', $event->id], ['confirm' => __('Are you sure you want to delete this record?', $event->id), 'class' => 'btn btn-sm text-danger', 'escape' => false,'rel'=>'tooltip','data-placement'=>'top', 'title'=>'Delete','data-toggle'=>'tooltip']) : ''; ?>
							 </td>
						</tr>

						<?php $sr_no++; ?>
					<?php endforeach; ?>
					</tbody>
			</table>
			</div>
			<?php if($this->Paginator->params()["pageCount"]==0){
		echo 'No Record Found';
	}else{?>
		<div class="pull-left pagingCount">
		<p><?php echo $this->Paginator->counter(
		'Page ' . $this->Paginator->params()["page"] . ' of ' . $this->Paginator->params()["pageCount"] . ', showing ' . $this->Paginator->params()["current"] . 
		' records out of
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
<?php $this->start('scriptBotton'); ?>
<script> 
	 $(document).ready(function () {
		//Add / Edit
		$("select#lang").change(function(){
			window.location.href = '<?php echo $this->Url->build(["action" => "index","?" => ["lang" => ""]]); ?>'+$(this).val();
		});
	});
</script>
<?php $this->end('scriptBotton'); ?>