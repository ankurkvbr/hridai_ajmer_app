<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Crafts & Foods List') ?></h1>
    <?php $this->Html->addCrumb(__('Crafts & Foods'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('Crafts & Foods List'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php
    echo
    $this->Html->getCrumbList(
            ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false], ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    );
    ?>
</section>
<!--<ul class="side-nav">
       <li class="heading"><?php echo __('Actions') ?></li>
       <li><?php echo $this->Html->link(__('Create New Crafts & Foods'), ['action' => 'add']) ?></li>
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

                        echo $this->Form->input('craftfood_category', [
                            'label' => " ",
                            'options' => array(""=>'Select Category',  1=>'Craft', 2=>'Food'),
                            'type' => 'select',
                            'default' => (!empty($this->request->query['craftfood_category']))? $this->request->query['craftfood_category']:'',
                        ]);
                        ?>
		</div>
		<?php echo $this->Form->button(__('Filter')) ?>
		<?php echo $this->Html->link('Reset',array('controller' => 'CraftFood', 'action' => 'index'),['type' => 'get','class'=>['btn btn-success']]); ?>
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
                            <th scope="col"><?php echo $this->Paginator->sort('category', __('Category')) ?></th>
                            <!--<th scope="col"><?php echo $this->Paginator->sort('description', __('Description')) ?></th>-->
                            <!--<th scope="col"><?php echo $this->Paginator->sort('short_description', __('Short Description')) ?></th>-->
                            <th scope="col"><?php echo $this->Paginator->sort('created_at', __('Created Date')) ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('is_active', __('Is Active')) ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('sort_order', __('Order')) ?></th>
							<!--<th scope="col"><?php echo $this->Paginator->sort('updated_at') ?></th>-->
                            <th scope="col" class="actions"><?php echo __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($this->Paginator->param('page') > 1) {
                            $sr_no = ($this->Paginator->param('perPage') * ($this->Paginator->param('page') - 1)) + 1;
                        } else {
                            $sr_no = 1;
                        }

                        foreach ($craftfoods as $craftfood):

                                $craftfood_created_at_AM = str_replace('पूर्वाह्न', 'AM',$craftfood->created_at);
                                $craftfood_created_at_PM = str_replace('अपराह्न', 'PM',$craftfood->created_at);
                                $craftfood_created_at = (strpos($craftfood_created_at_PM,'PM')) ? $craftfood_created_at_PM : $craftfood_created_at_AM;
                                if($language == 'hi'){
                                    $asCreated_at = explode('-',$craftfood_created_at);
                                    if(isset($asCreated_at[1]) && $asCreated_at[2]){
                                        $craftfood_created_at = $asCreated_at[1].'/'.$asCreated_at[0].'/'.$asCreated_at[2];
                                    }                                    
                                }
                            ?>
                            <tr>
                                <td><?php echo $this->Number->format($sr_no) ?></td>
                                <td><?php echo h($craftfood->title) ?></td>
                                <td><?php echo ($craftfood->category ==  1) ? 'Craft' : 'Food'; ?></td>
								<!--<td><?php echo h($craftfood->description) ?></td>-->
								<!--<td><?php echo h($craftfood->short_description) ?></td>-->
                                <td><?php echo h(date('d/m/Y',strtotime($craftfood_created_at))) ?></td>
                                <td><?php echo $craftfood->is_active ? __('Yes') : __('No');  ?></td>
                                <!--<td><?php echo h($craftfood->sort_order); ?></td>-->
								<td width="6%"><?php echo $this->Form->input('sort_order', array('class'=>'sort-order','role' => $craftfood->id , 'label' => false, 'value' => $craftfood->sort_order)); ?>
									<div id="success_msg_<?php echo $craftfood->id; ?>" style="display: none;"><font color="green">Saved</font></div>
								</td>
                                <!-- <td><?php echo h($craftfood->updated_at) ?></td>-->
                                <td class="textCenter actions">
                                    <?php echo $this->Html->link('<i class="fa fa-image"></i>', ['action' => 'viewimages', $craftfood->id], ['class' => 'btn btn-sm text-success', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'List of images', 'data-toggle' => 'tooltip']) ?>
                                    <?php //echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', ['action' => 'viewreview',$craftfood->id], ['class' => 'btn btn-sm text-success', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Review', 'data-toggle' => 'tooltip']) ?>
									
                                    <?php echo $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit',$craftfood->id,'?'=>['lang'=>$language]], ['class' => 'btn btn-sm text-success', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Edit', 'data-toggle' => 'tooltip']) ?>
                                    <?php echo ($language != 'hi') ? $this->Form->postLink('<i class="fa fa-remove"></i>', ['action' => 'delete', $craftfood->id], ['confirm' => __('Are you sure you want to delete this record ?'), 'class' => 'btn btn-sm text-danger', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delete', 'data-toggle' => 'tooltip']) : ''; ?>
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
		$(".sort-order").change(function(){
	
			sort_val = this.value;
			craftid = $(this).attr('role');
			$.ajax({
				type: "POST",
				url: "<?php echo $this->Url->build(['controller' => 'CraftFood', 'action' => 'addsort']); ?>",
				data: {
					'sort_val' : sort_val,
					'craftid' : craftid
				},
				dataType: "text",
				success: function(data){
					//we need to check if the value is the same
					$("#success_msg_"+craftid).show();
					setTimeout(function() { $("#success_msg_"+craftid).hide(); }, 5000);
					location.reload(true);
				}
			});
		});
	});
</script>
<?php $this->end('scriptBotton'); ?>
