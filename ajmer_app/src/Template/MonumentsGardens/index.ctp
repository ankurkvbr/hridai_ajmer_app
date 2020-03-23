<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Discoveries List') ?></h1>
    <?php $this->Html->addCrumb(__('Discoveries'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('Discoveries List'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php
    echo
    $this->Html->getCrumbList(
            ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false], ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    );
    ?>
</section>
<!--<ul class="side-nav">
       <li class="heading"><?php echo __('Actions') ?></li>
       <li><?php echo $this->Html->link(__('Create New Monuments Gardens'), ['action' => 'add']) ?></li>
</ul>--> 
<section class="content">
<div class="row searchLag">
	<div class="col-sm-9">
	<?php echo $this->Form->create(NULL,['type' => 'get','class'=>['form-inline']]) ?>
		<?php echo $this->Form->input('lang',['type'=>'hidden','id'=>'language','value' => $language]); ?>
		<div class="form-group">
			<?php echo $this->Form->input('search',[
			   'id'=>'search',
			   'label'=>false,
			   'placeholder' => h('Search by Title'),
			   'value' => (!empty($this->request->query['search']))? $this->request->query['search']:''
			]);

                       /* echo $this->Form->input('monuments_category', [
                            'label' => " ",
                            'options' => array(""=>'Select Category',  1=>'Monuments', 2=>'Gardens'),
                            'type' => 'select',
                            'default' => (!empty($this->request->query['monuments_category']))? $this->request->query['monuments_category']:'',
                        ]);*/
                        ?>
		</div>
		<?php echo $this->Form->button(__('Filter')) ?>
		<?php echo $this->Html->link('Reset',array('controller' => 'MonumentsGardens', 'action' => 'index'),['type' => 'get','class'=>['btn btn-success']]); ?>
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
                            <th scope="col"><?php echo  __('Sr. No.') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('title', __('Title')) ?></th>
                            <!--<th scope="col"><?php //echo $this->Paginator->sort('category', __('Category')) ?></th>-->
                            <!--<th scope="col"><?php //echo $this->Paginator->sort('state_id', __('State')) ?></th>-->
                            <!--<th scope="col"><?php //echo $this->Paginator->sort('cities_id', __('City')) ?></th>-->
                            <th scope="col"><?php echo $this->Paginator->sort('created_at', __('Created Date')) ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('is_active', __('Is Active')) ?></th>
							<th scope="col"><?php echo $this->Paginator->sort('sort_order', __('Order')) ?></th>
							<!--<th scope="col"><?php //echo $this->Paginator->sort('updated_at') ?></th>-->
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

                        foreach ($monumentsgardens as $monumentsgardens):

                                $monumentsgardens_created_at_AM = str_replace('पूर्वाह्न', 'AM',$monumentsgardens->created_at);
                                $monumentsgardens_created_at_PM = str_replace('अपराह्न', 'PM',$monumentsgardens->created_at);
                                $monumentsgardens_created_at = (strpos($monumentsgardens_created_at_PM,'PM')) ? $monumentsgardens_created_at_PM : $monumentsgardens_created_at_AM;
                                if($language == 'hi'){
                                    $asCreated_at = explode('-',$monumentsgardens_created_at);
                                    if(isset($asCreated_at[1]) && $asCreated_at[2]){
                                        $monumentsgardens_created_at = $asCreated_at[1].'/'.$asCreated_at[0].'/'.$asCreated_at[2];
                                    }                                    
                                }
                            ?>
                            <tr>
                                <td><?php echo $this->Number->format($sr_no) ?></td>
                                <td><?php echo h($monumentsgardens->title) ?></td>
                                <!--<td><?php //echo ($monumentsgardens->category ==  1) ? 'Monuments' : 'Gardens'; ?></td>-->
                                <!--<td><?php //echo $monumentsgardens->state->name;//$monumentsgardens->has('state') ? $this->Html->link($monumentsgardens->state->name, ['controller' => 'States', 'action' => 'view', $monumentsgardens->state->id]) : '' ?></td>-->
                                <!--<td><?php //echo $monumentsgardens->city->name;//$monumentsgardens->has('city') ? $this->Html->link($monumentsgardens->city->name, ['controller' => 'Cities', 'action' => 'view', $monumentsgardens->city->id]) : '' ?></td>-->
                                <td><?php echo h(date('d/m/Y',strtotime($monumentsgardens_created_at))) ?></td>
                                <td><?php echo $monumentsgardens->is_active ? __('Yes') : __('No');  ?></td>
								<!--<td><?php echo h($monumentsgardens->sort_order); ?></td>-->
								<td width="6%"><?php echo $this->Form->input('sort_order', array('class'=>'sort-order' ,'role' => $monumentsgardens->id, 'label' => false, 'value' => $monumentsgardens->sort_order)); ?>
									<div id="success_msg_<?php echo $monumentsgardens->id; ?>" style="display: none;"><font color="green">Saved</font></div>
								</td>
                                <!-- <td><?php echo h($monumentsgardens->updated_at) ?></td>-->
                                <td class="textCenter actions">
                                    <?php echo $this->Html->link('<i class="fa fa-image"></i>', ['action' => 'viewimages', $monumentsgardens->id], ['class' => 'btn btn-sm text-success', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'List of images', 'data-toggle' => 'tooltip']) ?>
                                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', ['action' => 'viewreview',$monumentsgardens->id], ['class' => 'btn btn-sm text-success', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Review', 'data-toggle' => 'tooltip']) ?>
									
                                    <?php echo $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit',$monumentsgardens->id,'?'=>['lang'=>$language]], ['class' => 'btn btn-sm text-success', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Edit', 'data-toggle' => 'tooltip']) ?>
                                    <?php echo ($language != 'hi') ? $this->Form->postLink('<i class="fa fa-remove"></i>', ['action' => 'delete', $monumentsgardens->id], ['confirm' => __('Are you sure you want to delete this record ?'), 'class' => 'btn btn-sm text-danger', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delete', 'data-toggle' => 'tooltip']) : ''; ?>
                                </td>
                            </tr>
                            <?php $sr_no++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php
            if ($this->Paginator->params()["pageCount"] == 0) {
                echo 'No Record Found';
            } else {
                ?>
                <div class="pull-left pagingCount">
                    <p><?php
                        echo $this->Paginator->counter(
                                'Page ' . $this->Paginator->params()["page"] . ' of ' . $this->Paginator->params()["pageCount"] . ', showing ' . $this->Paginator->params()["current"] . ' records out of
						' . $this->Paginator->params()["count"] . ' total');
                    }
                    ?>
                </p>
            </div>
            </div>
            <div class="paginator pull-right">
                <ul class="pagination">
                    <?php echo $this->Paginator->first('<< ' . __('first')) ?>
                    <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
                    <?php echo $this->Paginator->numbers() ?>
                    <?php echo $this->Paginator->next(__('next') . ' >') ?>
                    <?php echo $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
               <!-- <p><?php echo $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>-->
            </div>
        </div>
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
	$(".sort-order").change(function(){
	
			sort_val = this.value;
			monumentid = $(this).attr('role');
			$.ajax({
				type: "POST",
				url: "<?php echo $this->Url->build(['controller' => 'MonumentsGardens', 'action' => 'addsort']); ?>",
				data: {
					'sort_val' : sort_val,
					'monumentid' : monumentid
				},
				dataType: "text",
				success: function(data){
					//we need to check if the value is the same
					$("#success_msg_"+monumentid).show();
					setTimeout(function() { $("#success_msg_"+monumentid).hide(); }, 5000);
					location.reload(true);
				}
			});
		});
</script>
<?php $this->end('scriptBotton'); ?>
