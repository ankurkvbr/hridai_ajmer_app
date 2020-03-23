<section class="content-header">
    <h2><?php echo __('Image List') ?></h2>
    <h1><?php //echo __('Project Name : ').''.h($project_images->name)  ?></h1>

</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><?php echo __('Sr. No.') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('image', __('Name')) ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($this->Paginator->param('page') > 1) {
                            $sr_no = ($this->Paginator->param('perPage') * ($this->Paginator->param('page') - 1)) + 1;
                        } else {
                            $sr_no = 1;
                        }
                        foreach ($projectimage as $project):
                            ?>
                            <tr>
                                <td><?php echo $this->Number->format($sr_no) ?></td>
                                <td><img src="<?php echo 'resize/100x100/img/event/' . @$project->project_images[0]->image; ?>"/></td>
                                <td><?php //echo h($project->image)  ?></td>
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
            </div>
        </div>
    </div>	