<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
	<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
	<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
	<div class="page-sidebar navbar-collapse collapse">
		<!-- BEGIN SIDEBAR MENU -->
		<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
		<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
		<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
		<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
			<li class="sidebar-toggler-wrapper" style="margin-bottom:10px">
				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				<div class="sidebar-toggler">
				</div>
				<!-- END SIDEBAR TOGGLER BUTTON -->
			</li>
			
			<?php
				$i = 1;
				foreach($menu_items as $key => $menu){
					$start = $i++ == 1 ? 'start' : '';
					$active = ($key == $menu_active) ? 'active' : '';
			?>
				<li class="<?php echo $start .' '. $active ?>">
					<a href="<?php echo $menu['link'] ?>">
						<?php $icon = $menu['icon'] != '' ? $menu['icon'] : 'icon-layers'; ?>
						<i class="<?php echo $icon; ?>"></i>
						<span class="title"><?php echo $menu['text'] ?></span>
						<?php
							if(!empty($menu['sub_menu'])){
								echo '<span class="arrow "></span>';
							}
						?>
					</a>
					<?php if(!empty($menu['sub_menu'])){ ?>
						<ul class="sub-menu">
							<?php 
								foreach($menu['sub_menu'] as $s_key => $s_menu){ 
									$active = ($s_key == $sub_menu_active && $key == $menu_active) ? 'active' : '';
							?>
							<li class="<?php echo $active ?>">
								<a href="<?php echo $s_menu['link'] ?>">
								<?php echo $s_menu['icon'] != '' ? '<i class="'.$s_menu['icon'].'"></i>' : ''; ?>
								<?php echo $s_menu['text'] ?></a>
							</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</li>
			<?php
				}
			?>
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>
<!-- END SIDEBAR -->