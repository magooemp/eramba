<ul class="nav navbar-nav navbar-left hidden-xs hidden-sm">
	<?php foreach ($menuItems as $section) : ?>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php echo $section['name']; ?>
				<!--&nbsp;<i class="icon-caret-down small"></i>-->
			</a>
			<ul class="dropdown-menu">
				<?php foreach ($section['children'] as $action) : ?>
				<li>
					<?php 
					echo $this->Html->link( 
						$action['name'], 
						$action['url']
					);
					?>
				</li>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php endforeach; ?>
</ul>