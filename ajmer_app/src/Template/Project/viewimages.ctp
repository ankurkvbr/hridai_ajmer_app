<?php // $this->Html->script(['jquery.min.js'], ['block' => 'script']);  ?>
<?php $this->Html->script(['jquery.ui.js'], ['block' => 'script']); ?>
<section class="content-header">
    <h2><?php echo __('Image List') ?></h2>
	<?php $this->Html->addCrumb(__('Projects'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('Image List'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php
    echo
    $this->Html->getCrumbList(
            ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false], ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    );
	?>
    <h4><?php echo __('Project Name : ').''.h($title)      ?></h4>

</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">

            </div>
            <section>
                <div class="container">

                    <button class="save save_order">Save order</button>
                    <div id="response"></div>

                    <ul class="sortable" id="sortable">
                        <?php
                        $i = 1;
                        foreach ($project as $projectImages):
                            ?>
                            <li id='item-<?php echo $projectImages->id; ?>' class="sortableli" style="margin:10px; float:left; list-style:none;">
                                <img id="<?php echo $projectImages->id.'-'.$projectImages->shorting_order; ?>" src="<?php echo $this->request->webroot . "img/project/" . h($projectImages->image) ?>" alt="" width="100" height="100">
                            </li>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </ul>

                </div>
            </section>
        </div>
    </div>
<?php $this->start('scriptBotton'); ?>
    <script type="text/javascript">
        var ul_sortable = $('.sortable'); //setup one variable for sortable holder that will be used in few places
        /*
         * jQuery UI Sortable setup
         */
        ul_sortable.sortable({
            revert: 100,
            placeholder: 'placeholder'
        });
        ul_sortable.disableSelection();
        /*
         * Saving and displaying serialized data
         */
        var btn_save = $('button.save'),
                div_response = $('#response');
        btn_save.on('click', function (e) { // trigger function on save button click
            e.preventDefault();

            var sortable_data = ul_sortable.sortable('serialize'); // serialize data from ul#sortable
            $.ajax({//aja
                data: sortable_data,
                type: 'POST',
                url: '<?php echo $this->Url->build(['controller' => 'Project', 'action' => 'changeorder']); ?>', // save.php - file with database update
                success: function (result) {
                    div_response.text(result);
                }
            });
        });
        
    </script>
<?php $this->end('scriptBotton'); ?>