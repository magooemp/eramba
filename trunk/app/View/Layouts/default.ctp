<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title>
		<?php 
		echo $title_for_layout .(!empty($title_for_layout) ? ' | ' : ''). (defined('NAME_SERVICE') ? NAME_SERVICE : DEFAULT_NAME);
		?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		$cssFiles = array(
			'bootstrap.min',
			'main',
			'plugins',
			'responsive',
			'login',
			'icons',
			'fontawesome/font-awesome.min',
			'eramba'
		);

		$jsFiles = array(
			'libs/jquery-1.10.2.min',
			'plugins/jquery-ui/jquery-ui-1.10.2.custom.min',
			'bootstrap.min',
			'libs/lodash.compat.min',
			'plugins/touchpunch/jquery.ui.touch-punch.min',
			'plugins/event.swipe/jquery.event.move',
			'plugins/event.swipe/jquery.event.swipe',
			'libs/breakpoints',
			'plugins/respond/respond.min',
			'plugins/cookie/jquery.cookie.min',
			'plugins/slimscroll/jquery.slimscroll.min',
			'plugins/slimscroll/jquery.slimscroll.horizontal.min',
			'plugins/sparkline/jquery.sparkline.min',
			'plugins/flot/jquery.flot.min',
			'plugins/flot/jquery.flot.tooltip.min',
			'plugins/flot/jquery.flot.resize.min',
			'plugins/flot/jquery.flot.time.min',
			'plugins/flot/jquery.flot.growraf.min',
			'plugins/easy-pie-chart/jquery.easy-pie-chart.min',
			'plugins/daterangepicker/moment.min',
			'plugins/daterangepicker/daterangepicker',
			'plugins/blockui/jquery.blockUI.min',
			'plugins/fullcalendar/fullcalendar.min',
			'plugins/noty/jquery.noty',
			'plugins/noty/layouts/top',
			'plugins/noty/themes/default',
			'plugins/uniform/jquery.uniform.min',
			'plugins/select2/select2.min',
			'app',
			'plugins',
			'plugins.form-components',
			'custom'
		);

		echo $this->Html->css( $cssFiles );
		echo $this->Html->script( $jsFiles );

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		"use strict";

		App.init(); // Init layout and core plugins
		Plugins.init(); // Init all plugins
		FormComponents.init(); // Init all form-specific plugins
	});
	</script>

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
</head>
<body <?php if ( $logged == null ) echo 'class="login"'; ?>>

	<?php if ($this->Session->check('Message.flash')) : ?>
		<?php echo $this->Session->flash(); ?>
	<?php endif; ?>

	<?php if ( $logged != null ) : ?>

		<?php echo $this->element( CORE_ELEMENT_PATH . 'header' ); ?>
		
		<div id="container" class="sidebar-closed">

			<div id="content">

				<div class="container">

					<?php echo $this->element( CORE_ELEMENT_PATH . 'breadcrumbs' ); ?>

					<?php echo $this->element( CORE_ELEMENT_PATH . 'page_header' ); ?>

					<?php echo $this->fetch( 'content' ); ?>

				</div>

			</div>

		</div>

	<?php else : ?>
		<div class="logo">
			<strong>E</strong>ramba
		</div>

		<?php echo $this->fetch( 'content' ); ?>
	<?php endif; ?>

</body>
</html>
