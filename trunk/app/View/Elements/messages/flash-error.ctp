<script type="text/javascript">
	jQuery(document).ready(function($){
		$(window).on("load", function(e) {
			noty({
				text: '<strong><?php echo $message; ?></strong>',
				type: 'error',
				timeout: 3000
			});
		});
	});
</script>