<!-- Content Header (Page header) -->
<section class="content-header">
<h1><?php echo __('FAQ List') ?></h1>
<?php $this->Html->addCrumb(__('FAQ'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('FAQ List'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php echo $this->Html->getCrumbList(
        ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false],
        ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    );
?>
</section>
<?php /* Searching */ ?>
	
	<?php /* Language drop down */ ?>
	
<section class="content">
<div class="row searchLag">
	<div class="col-sm-9">
	<?php echo $this->Form->create(NULL,['type' => 'get','class'=>['form-inline']]) ?>
		<?php echo $this->Form->input('lang',['type'=>'hidden','id'=>'language','value' => $language]); ?>
		<div class="form-group">
			<?php echo $this->Form->input('search',[
			   'id'=>'search',
			   'label'=>false,
			   'placeholder' => h('Search by Question'),
			   'value' => (!empty($this->request->query['search']))? $this->request->query['search']:''
			]);?>
		</div>
		<?php echo $this->Form->button(__('Filter')) ?>
		<?php echo $this->Html->link('Reset',array('controller' => 'FaqMaster', 'action' => 'index'),['type' => 'get','class'=>['btn btn-success']]); ?>
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
							<th scope="col"><?php echo $this->Paginator->sort('faq_title',__('Question')) ?></th>
							<th scope="col"><?php echo $this->Paginator->sort('faq_description',__('Answer')) ?></th>
							<th scope="col"><?php echo $this->Paginator->sort('created_at', __('Created Date')) ?></th>
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
					
					foreach ($faqMaster as $faqMaster): 
								$faqmaster_created_at_AM = str_replace('पूर्वाह्न', 'AM',$faqMaster->created_at);
                                $faqmaster_created_at_PM = str_replace('अपराह्न', 'PM',$faqMaster->created_at);
                                $faqmaster_created_at = (strpos($faqmaster_created_at_PM,'PM')) ? $faqmaster_created_at_PM : $faqmaster_created_at_AM;
                                if($language == 'hi'){
                                    $asCreated_at = explode('/',$faqmaster_created_at);
                                    if(isset($asCreated_at[1]) && $asCreated_at[2]){
                                        $faqmaster_created_at = $asCreated_at[1].'/'.$asCreated_at[0].'/'.$asCreated_at[2];
                                    }                                    
                                }
					
					?>
						<tr>
							<td><?php echo $this->Number->format($sr_no) ?></td>
							<td><?php echo h($faqMaster->faq_title) ?></td>
							<td><?php echo strip_tags(strtok(wordwrap($faqMaster->faq_description, 50, "...\n"), "\n")); ?></td>
							
							<td><?php echo h(date('d/m/Y',strtotime($faqmaster_created_at))) ?></td>
							<td><?php echo  $faqMaster->is_active ? __('Yes') : __('No'); ?></td>
							<td class="textCenter actions">
								<?php echo $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit',base64_encode($faqMaster->id),'?'=>['lang'=>$language]], ['class' => 'btn btn-sm text-success', 'escape' => false,'rel'=>'tooltip','data-placement'=>'top', 'title'=>'Edit','data-toggle'=>'tooltip']) ?>
								<?php echo ($language != 'hi') ? $this->Form->postLink('<i class="fa fa-remove"></i>', ['action' => 'delete', $faqMaster->id], ['confirm' => __('Are you sure you want to delete this record ?', $faqMaster->id), 'class' => 'btn btn-sm text-danger', 'escape' => false,'rel'=>'tooltip','data-placement'=>'top', 'title'=>'Delete','data-toggle'=>'tooltip']) : '' ; ?>
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
    'Page ' . $this->Paginator->params()["page"] . ' of ' . $this->Paginator->params()["pageCount"] . ', showing ' . $this->Paginator->params()["current"] . ' records out of
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