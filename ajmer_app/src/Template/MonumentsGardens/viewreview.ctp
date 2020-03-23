<section class="content-header">
    <h2><?php echo __('Monuments-Review List') ?></h2>
    <h1><?php echo __('Monuments-Gardens Name : ').''.h($review->title) ?></h1>
    
</section>
<section class="content">

<div class="row">
        <div class="col-xs-12">
            <div class="box">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><?php echo  __('Sr. No.') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('title', __('Title')) ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('review', __('Review')) ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('rating', __('Rating')) ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('created_at', __('Date')) ?></th>
                            </th>
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
						
                        foreach ($monumentreviews as $monumentreview):
                            ?>
                            <tr>
                                <td><?php echo $this->Number->format($sr_no) ?></td>
                                <td><?php echo h($monumentreview->title) ?></td>
                                <td><?php echo strtok(wordwrap($monumentreview->review, 100, "...\n"), "\n");?>
								</td>
                                <td><?php echo h($monumentreview->rating) ?>
																	
								<?php
								/*for($x=1;$x<=$monumentreview->rating;$x++) {
									echo '<img src="path/to/half/star.png"" />';
								}
								
								if (strpos($monumentreview->rating,'.')) {
									echo '<img src="path/to/half/star.png" />';
									$x++;
								}*/
								?>
								</td>
                                 <td><?php echo h(date('d/m/Y',strtotime($monumentreview->created_at))) ?></td>
							
								<td class="textCenter actions">
						
									<?php if($monumentreview->is_publish != 1){
									echo $this->Form->postLink('<img src="../../img/N.gif" />',['action' => 'viewreview', $monumentreview->monument_id,'?'=>['id'=>$monumentreview->id,'is_publish'=>1]], ['confirm' => __('Are you sure want to publish this review ?'), 'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Active', 'data-toggle' => 'tooltip']) ;
									}
									else
									{
									echo $this->Form->postLink('<img src="../../img/Y.gif" />', ['action' => 'viewreview', $monumentreview->monument_id,'?'=>['id'=>$monumentreview->id,'is_publish'=>0]], ['confirm' => __('Are you sure want to unpublish this review ?'),  'escape' => false, 'rel' => 'tooltip', 'data-placement' => 'top', 'title' => 'Active', 'data-toggle' => 'tooltip']) ;
									}
									?>
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
            </div>
        </div>
</div>	
		