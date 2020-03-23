<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Project List') ?></h1>
    <?php $this->Html->addCrumb(__('Projects'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('Project List'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php
    echo
    $this->Html->getCrumbList(
            ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false], ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    );
    ?>
</section>
<!--<ul class="side-nav">
       <li class="heading"><?php echo __('Actions') ?></li>
       <li><?php echo $this->Html->link(__('Create New Event'), ['action' => 'add']) ?></li>
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
                               'placeholder' => h('Search by Project Name'),
                               'value' => (!empty($this->request->query['search']))? $this->request->query['search']:''
                            ]);?>
                    </div>
                    <?php echo $this->Form->button(__('Filter')) ?>
                    <?php echo $this->Html->link('Reset',array('controller' => 'Project', 'action' => 'index'),['type' => 'get','class'=>['btn btn-success']]); ?>
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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><?php echo  __('Sr. No.') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('project_name', __('Name')) ?></th>
                           <!-- <th scope="col"><?php //echo $this->Paginator->sort('state_id', __('State')) ?></th>-->
                            <!--<th scope="col"><?php //echo $this->Paginator->sort('cities_id', __('City')) ?></th>-->
                            <!--<th scope="col"><?php echo $this->Paginator->sort('url', __('Url')) ?></th>-->
                            <th scope="col"><?php echo $this->Paginator->sort('created_at', __('Created Date')) ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('is_active', __('Is Active')) ?></th>
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

                        foreach ($project as $project):
                            $project_created_at_AM = str_replace('पूर्वाह्न', 'AM',$project->created_at);
                                $project_created_at_PM = str_replace('अपराह्न', 'PM',$project->created_at);
                                $project_created_at = (strpos($project_created_at_PM,'PM')) ? $project_created_at_PM : $project_created_at_AM;
                                if($language == 'hi'){
                                    $asCreated_at = explode('-',$project_created_at);
                                    if(isset($asCreated_at[1]) && $asCreated_at[2]){
                                        $project_created_at = $asCreated_at[1].'/'.$asCreated_at[0].'/'.$asCreated_at[2];
                                    }                                    
                                }
							?>
                            <tr>
                                <td><?php echo $this->Number->format($sr_no) ?></td>
                                <td><?php echo h($project->project_name) ?></td>
                                <!--<td><?php //echo $project->state->name; //$project->has('state') ? $this->Html->link($project->state->name, ['controller' => 'States', 'action' => 'view', $project->state->id]) : '' ?></td>-->
                                <!--<td><?php //echo $project->city->name;//$project->has('city') ? $this->Html->link($project->city->name, ['controller' => 'Cities', 'action' => 'view', $project->city->id]) : '' ?></td>-->

                                <!--<td><?php echo h($project->url) ?></td>-->
                                <td><?php echo h(date('d/m/Y',strtotime($project_created_at))) ?></td>
                                <td><?php echo $project->is_active ? __('Yes') : __('No');  ?></td>
								
    <!-- <td><?php //echo h($project->updated_at) ?></td>-->
                                <td class="textCenter actions">
									<?php echo $this->Html->link('<i class="fa fa-image"></i>', ['action' => 'viewimages', $project->id], ['class' => 'btn btn-sm text-success', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'List of images', 'data-toggle' => 'tooltip']) ?>
                                    <?php echo $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $project->id,'?'=>['lang'=>$language]], ['class' => 'btn btn-sm text-success', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Edit', 'data-toggle' => 'tooltip']) ?>
                                    <?php echo ($language != 'hi') ? $this->Form->postLink('<i class="fa fa-remove"></i>', ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete this record?', $project->id), 'class' => 'btn btn-sm text-danger', 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delete', 'data-toggle' => 'tooltip']) : ''; ?>
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
</script>
<?php $this->end('scriptBotton'); ?>
