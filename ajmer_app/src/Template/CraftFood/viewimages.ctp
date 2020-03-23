<?php // $this->Html->script(['jquery.min.js'], ['block' => 'script']);  ?>
<?php $this->Html->script(['jquery.ui.js'], ['block' => 'script']); ?>
<section class="content-header">
    <h2><?php echo __('Image List') ?></h2>
	<?php $this->Html->addCrumb(__('Crafts & Foods'), 'javascript:void(0);'); ?>
    <?php $this->Html->addCrumb(__('Image List'), 'javascript:void(0);', ['class' => 'active']); ?>
    <?php
    echo
    $this->Html->getCrumbList(
            ['firstClass' => false, 'lastClass' => 'active', 'class' => 'breadcrumb', 'escape' => false], ['text' => __('<i class="fa fa-dashboard"></i> Dashboard'), 'url' => ['controller' => 'Dashboard', 'action' => 'index']]
    );
    ?>
    <h4><?php echo __('Crafts & Foods Name  : ').''.h($title)      ?></h4>

</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
            </div>
			                    <div id="response"></div>
            <section>
                <div class="container galleryContent">

                    <button class="save save_order">Save order</button>

                    <ul class="sortable" id="sortable">
                        <?php
                        $i = 1;
                        foreach ($craft_food as $craftsfoodsImages):
                            ?>
                            <li id='item-<?php echo $craftsfoodsImages->id; ?>' class="sortableli">
                                <img id="<?php echo $craftsfoodsImages->id.'-'.$craftsfoodsImages->shorting_order; ?>" src="<?php echo $this->request->webroot . "img/craftfood/" . h($craftsfoodsImages->image) ?>" alt="">
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
                url: '<?php echo $this->Url->build(['controller' => 'CraftFood', 'action' => 'changeorder']); ?>', // save.php - file with database update
                success: function (result) {
                    div_response.text(result);
					 $('#response').addClass('alert alert-success');
                }
            });
        });
        
    </script>
<?php $this->end('scriptBotton'); ?>