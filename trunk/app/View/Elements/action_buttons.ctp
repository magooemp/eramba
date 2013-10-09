<ul class="table-controls">
	<li>
		<?php echo $this->Html->link( '<i class="icon-pencil"></i>', array(
			'controller' => $controller,
			'action' => 'edit',
			$id
		), array(
			'class' => 'bs-tooltip',
			'escape' => false,
			'title' => __( 'Edit' )
		) ); ?>
	</li>
	<li>
		<?php echo $this->Html->link( '<i class="icon-trash"></i>', array(
			'controller' => $controller,
			'action' => 'delete',
			$id
		), array(
			'class' => 'bs-tooltip button-prompt-remove',
			'escape' => false,
			'title' => __( 'Trash' )
		) ); ?>
	</li>
</ul>