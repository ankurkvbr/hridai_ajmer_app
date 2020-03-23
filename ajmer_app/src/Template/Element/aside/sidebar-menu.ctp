<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li><a href="<?php echo $this->Url->build('/'); ?>"><i class="fa fa-dashboard"></i> <span><?= __('Dashboard');?></span></a></li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span><?= __('User Management');?></span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'Users','action'=>'index']); ?>"><i class="fa fa-circle-o"></i><?= __('User List');?></a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'Users','action'=>'add']); ?>"><i class="fa fa-circle-o"></i><?= __('Add User');?></a></li>
        </ul>
    </li>
    <!--
    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span><?= __('FAQ');?></span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'FaqMaster','action'=>'index']); ?>"><i class="fa fa-circle-o"></i><?= __('FAQ List');?></a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'FaqMaster','action'=>'add']); ?>"><i class="fa fa-circle-o"></i><?= __('Add FAQ');?></a></li>
        </ul>
    </li>
    -->
    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span><?= __('CMS');?></span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'CmsPage','action'=>'index']); ?>"><i class="fa fa-circle-o"></i><?= __('CMS Page List');?></a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'CmsPage','action'=>'add']); ?>"><i class="fa fa-circle-o"></i><?= __('Add CMS Page');?></a></li>
        </ul>
    </li>
    <!-- <li class="treeview">
         <a href="#">
             <i class="fa fa-dashboard"></i> <span><?= __('Role Management');?></span> <i class="fa fa-angle-left pull-right"></i>
         </a>
         <ul class="treeview-menu">
             <li><a href="<?php //echo $this->Url->build(['controller'=>'Roles','action'=>'index']); ?>"><i class="fa fa-circle-o"></i><?= __('Role List');?></a></li>
             <li><a href="<?php //echo $this->Url->build(['controller'=>'Roles','action'=>'add']); ?>"><i class="fa fa-circle-o"></i><?= __('Create New Role');?></a></li>
         </ul>
     </li> -->
    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span><?= __('Fairs & Festivals');?></span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'Event','action'=>'index']); ?>"><i class="fa fa-circle-o"></i><?= __('Fairs & Festivals List');?></a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'Event','action'=>'add']); ?>"><i class="fa fa-circle-o"></i><?= __('Add Fairs & Festivals');?></a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span><?= __('Projects');?></span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'Project','action'=>'index']); ?>"><i class="fa fa-circle-o"></i><?= __('Projects List');?></a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'Project','action'=>'add']); ?>"><i class="fa fa-circle-o"></i><?= __('Add Project');?></a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span><?= __('Discoveries');?></span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'MonumentsGardens','action'=>'index']); ?>"><i class="fa fa-circle-o"></i><?= __('Discoveries List');?></a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'MonumentsGardens','action'=>'add']); ?>"><i class="fa fa-circle-o"></i><?= __('Add Discoveries');?></a></li>
        </ul>
    </li>
	 <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span><?= __('Crafts & Foods');?></span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'CraftFood','action'=>'index']); ?>"><i class="fa fa-circle-o"></i><?= __('Crafts & Foods List');?></a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'CraftFood','action'=>'add']); ?>"><i class="fa fa-circle-o"></i><?= __('Add Crafts & Foods');?></a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span><?= __('Feedback');?></span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'Feedback','action'=>'index']); ?>"><i class="fa fa-circle-o"></i><?= __('Feedback List');?></a></li>

        </ul>
    </li>
</ul>
