<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="#">
				<?php echo CHtml::encode(Yii::app()->name); ?>
				</a>
				<!-- END LOGO -->
			
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<img src="../../images/menu-toggler.png" alt="" />
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->            
				<!-- BEGIN TOP NAVIGATION MENU -->              
				<ul class="nav pull-right">
				              
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
<!--					<img alt="" src="../../images/avatar1_small.jpg" />-->
                                                    <?php echo Yii::t('admin_layouts_column1','last_login_text'); ?> (<?php echo  Yii::app()->dateFormatter->formatDateTime(Yii::app()->user->getState('last_login'), 'long', null)
                                                            
                                                            //Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(Yii::app()->user->getState('last_login'), 'yyyy-MM-dd'),'medium',null); 
                                                            ?>)
                                                    <span class="username"><?php echo ucfirst(Yii::app()->user->name);?></span>
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
						<?php //if(Yii::app()->user->usertype == 'backuser')
						//{
						?>
							<li><a href="<?php echo Yii::app()->createUrl('admin/updateaccount')?>"><i class="icon-user"></i><?php echo Yii::t('admin_layouts_column1','my_profile_text'); ?></a></li>
							<li><a href="<?php echo Yii::app()->createUrl('admin/changepassword')?>"><i class="icon-lock"></i><?php echo Yii::t('admin_layouts_column1','change_password_text'); ?></a></li>
						<?php
						//}
						?>	
							<li><a href="<?php echo Yii::app()->createUrl('index/logout')?>"><i class="icon-key"></i> <?php echo Yii::t('admin_layouts_column1','logout_text');?></a> </li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU --> 
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
<!-- header -->

<div class="page-sidebar nav-collapse collapse">
 <!-- BEGIN SIDEBAR MENU -->        
			<ul class="page-sidebar-menu">
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li class="start index parent">
                                    
					<a href="<?php echo Yii::app()->createUrl('index/index')?>">
					<i class="icon-home"></i> 
					<span class="title"><?php echo Yii::t('admin_layouts_column1','dashboard_text');?></span>
					<span class="selected"></span>	
					</a>
                                    
				</li>
				
				<li class="masters parent ">
					<a href="javascript:;">
					<i class="icon-folder-open"></i> 
					<span class="title" ><?php echo Yii::t('admin_layouts_column1','masters_text');?></span>
					<span class="arrow mastersarrow "></span>
					<span class="selected"></span>	
					</a>
					<ul class="sub-menu">
                                                <li class="language" class="active">
							<a href="javascript:;">
							<i class="icon-reorder"></i> 
							<?php echo Yii::t('admin_layouts_column1','language_text');?>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="admin"><a href="<?php echo Yii::app()->createUrl('language/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
								<li class="create" ><a href="<?php echo Yii::app()->createUrl('language/create')?>"><i class="icon-plus"></i><?php echo Yii::t('admin_layouts_column1','add_text');?></a></li>
							</ul>
						</li>
						<li class="country" class="active">
							<a href="javascript:;">
							<i class="icon-reorder"></i> 
							<?php echo Yii::t('admin_layouts_column1','country_text');?>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="admin"><a href="<?php echo Yii::app()->createUrl('country/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
								<li class="create" ><a href="<?php echo Yii::app()->createUrl('country/create')?>"><i class="icon-plus"></i><?php echo Yii::t('admin_layouts_column1','add_text');?></a></li>
							</ul>
						</li>
						<li class="state" >
							<a href="javascript:;">
							<i class="icon-reorder"></i> 
							<?php echo Yii::t('admin_layouts_column1','state_text');?>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="admin" ><a href="<?php echo Yii::app()->createUrl('state/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
								<li class="create" ><a href="<?php echo Yii::app()->createUrl('state/create')?>"><i class="icon-plus"></i><?php echo Yii::t('admin_layouts_column1','add_text');?></a></li>
							</ul>
						</li>
                                                <li class="region" >
							<a href="javascript:;">
							<i class="icon-reorder"></i> 
							<?php echo Yii::t('admin_layouts_column1','region_text');?>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="admin" ><a href="<?php echo Yii::app()->createUrl('region/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
								<li class="create" ><a href="<?php echo Yii::app()->createUrl('region/create')?>"><i class="icon-plus"></i><?php echo Yii::t('admin_layouts_column1','add_text');?></a></li>
							</ul>
						</li>
                                                <li class="city" >
							<a href="javascript:;">
							<i class="icon-reorder"></i> 
							<?php echo Yii::t('admin_layouts_column1','city_text');?>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="admin" ><a href="<?php echo Yii::app()->createUrl('city/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
								<li class="create" ><a href="<?php echo Yii::app()->createUrl('city/create')?>"><i class="icon-plus"></i><?php echo Yii::t('admin_layouts_column1','add_text');?></a></li>
							</ul>
						</li>
						<li class="category" >
							<a href="javascript:;">
							<i class="icon-reorder"></i> 
							<?php echo Yii::t('admin_layouts_column1','category_text');?>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="admin" ><a href="<?php echo Yii::app()->createUrl('category/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
								<li class="create" ><a href="<?php echo Yii::app()->createUrl('category/create')?>"><i class="icon-plus"></i><?php echo Yii::t('admin_layouts_column1','add_text');?></a></li>								                                                                
							</ul>							
						</li>
                                                <li class="categoryquestion" >
							<a href="javascript:;">
                                                        <i class="icon-reorder"></i>
                                                        Category Question
                                                        <span class="arrow"></span>
                                                        </a>
                                                        <ul class="sub-menu">
                                                                <li class="admin"><a href="<?php echo Yii::app()->createUrl('categoryquestion/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
                                                                <li class="create"><a href="<?php echo Yii::app()->createUrl('categoryquestion/create')?>"><i class="icon-plus"></i><?php echo Yii::t('admin_layouts_column1','add_text');?></a></li>
                                                        </ul>
						</li>
                                                <li class="skill" >
							<a href="javascript:;">
                                                        <i class="icon-reorder"></i>
                                                        Category Skill
                                                        <span class="arrow"></span>
                                                        </a>
                                                        <ul class="sub-menu">
                                                                <li class="admin"><a href="<?php echo Yii::app()->createUrl('skill/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
                                                                <li class="create"><a href="<?php echo Yii::app()->createUrl('skill/create')?>"><i class="icon-plus"></i><?php echo Yii::t('admin_layouts_column1','add_text');?></a></li>
                                                        </ul>
						</li>
                                                <li class="task" >
							<a href="javascript:;">
                                                        <i class="icon-reorder"></i>
                                                        Task List
                                                        <span class="arrow"></span>
                                                        </a>
                                                        <ul class="sub-menu">
                                                                <li class="admin"><a href="<?php echo Yii::app()->createUrl('task/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
                                                        </ul>
						</li>
						<li class="adminuser">
							<a href="javascript:;">
							<i class="icon-reorder"></i> 
							<?php echo Yii::t('admin_layouts_column1','admin_user_text');?>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="admin" ><a href="<?php echo Yii::app()->createUrl('admin/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
								<li class="create" ><a href="<?php echo Yii::app()->createUrl('admin/create')?>"><i class="icon-plus"></i><?php echo Yii::t('admin_layouts_column1','add_text');?></a></li>
							</ul>
						</li>
						
						<li class="roles" >
							<a href="javascript:;">
							<i class="icon-reorder"></i> 
							<?php echo Yii::t('admin_layouts_column1','admin_roles_text');?>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="admin" ><a href="<?php echo Yii::app()->createUrl('roles/admin')?>"><i class="icon-cogs"></i><?php echo Yii::t('admin_layouts_column1','manage_text');?></a></li>
								<li class="create" ><a href="<?php echo Yii::app()->createUrl('roles/create')?>"><i class="icon-plus"></i><?php echo Yii::t('admin_layouts_column1','add_text');?></a></li>
							</ul>
						</li>
					</ul>
				</li>
</ul>
			<!-- END SIDEBAR MENU -->
		
	</div><!-- mainmenu -->



	<div class="page-content">

	
	<div class="container-fluid">
           <div id="timeout"></div> 
		<?php UtilityHtml::flashMessage(); ?>
             
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
                   // 'homeLink'=>('Dashboard')
                    'homeLink' => CHtml::link ('Dashboard',array('/index/index')),

		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<?php echo $content; ?></div></div>
<!-- content -->
<?php $this->endContent(); ?>