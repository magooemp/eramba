<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css( 'bootstrap.min' );
		echo $this->Html->css( 'main' );
		echo $this->Html->css( 'plugins' );
		echo $this->Html->css( 'responsive' );
		echo $this->Html->css( 'icons' );
		echo $this->Html->css( 'fontawesome/font-awesome.min' );

		echo $this->Html->script( 'libs/jquery-1.10.2.min' );
		echo $this->Html->script( 'plugins/jquery-ui/jquery-ui-1.10.2.custom.min' );
		echo $this->Html->script( 'bootstrap.min' );
		echo $this->Html->script( 'libs/lodash.compat.min' );
		echo $this->Html->script( 'plugins/touchpunch/jquery.ui.touch-punch.min' );
		echo $this->Html->script( 'plugins/event.swipe/jquery.event.move' );
		echo $this->Html->script( 'plugins/event.swipe/jquery.event.swipe' );
		echo $this->Html->script( 'libs/breakpoints' );
		echo $this->Html->script( 'plugins/respond/respond.min' );
		echo $this->Html->script( 'plugins/cookie/jquery.cookie.min' );
		echo $this->Html->script( 'plugins/slimscroll/jquery.slimscroll.min' );
		echo $this->Html->script( 'plugins/slimscroll/jquery.slimscroll.horizontal.min' );
		echo $this->Html->script( 'plugins/sparkline/jquery.sparkline.min' );

		echo $this->Html->script( 'plugins/flot/jquery.flot.min' );
		echo $this->Html->script( 'plugins/flot/jquery.flot.tooltip.min' );
		echo $this->Html->script( 'plugins/flot/jquery.flot.resize.min' );
		echo $this->Html->script( 'plugins/flot/jquery.flot.time.min' );
		echo $this->Html->script( 'plugins/flot/jquery.flot.growraf.min' );
		echo $this->Html->script( 'plugins/easy-pie-chart/jquery.easy-pie-chart.min' );

		echo $this->Html->script( 'plugins/daterangepicker/moment.min' );
		echo $this->Html->script( 'plugins/daterangepicker/daterangepicker' );
		echo $this->Html->script( 'plugins/blockui/jquery.blockUI.min' );
		echo $this->Html->script( 'plugins/fullcalendar/fullcalendar.min' );
		echo $this->Html->script( 'plugins/noty/jquery.noty' );
		echo $this->Html->script( 'plugins/noty/layouts/top' );
		echo $this->Html->script( 'plugins/noty/themes/default' );
		echo $this->Html->script( 'plugins/uniform/jquery.uniform.min' );
		echo $this->Html->script( 'plugins/select2/select2.min' );

		echo $this->Html->script( 'app' );
		echo $this->Html->script( 'plugins' );
		echo $this->Html->script( 'plugins.form-components' );


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
<body>

	<?php echo $this->element( 'header' ); ?>
	<div id="container" class="fixed-header sidebar-closed">

		<div id="content">

			<div class="container">

				<?php echo $this->Session->flash(); ?>

				<?php echo $this->fetch('content'); ?>

			</div>

		</div>

	</div>

	<?php echo $this->element('sql_dump'); ?>

</body>
</html>
