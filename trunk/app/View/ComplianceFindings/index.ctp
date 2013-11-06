<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'complianceFindings',
						'action' => 'add',
						$compliance_audit_id
					), array(
						'class' => 'btn',
						'escape' => false
					) ); ?>
					
					<button class="btn dropdown-toggle" data-toggle="dropdown"><?php echo __( 'Actions' ); ?> <span class="caret"></span></button>
					<ul class="dropdown-menu pull-right" style="text-align: left;">
						<li><a href="#"><i class="icon-file"></i> <?php echo __( 'Export' ); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="widget">
			<?php if ( ! empty( $data ) ) : ?>
				<table class="table table-hover table-striped table-bordered table-highlight-head">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort( 'ComplianceFinding.title', __( 'Title' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'ComplianceFinding.description', __( 'Description' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'ComplianceFinding.deadline', __( 'Deadline' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'ComplianceFindingStatus.name', __( 'Status' ) ); ?></th>
							<th class="align-center"><?php echo __( 'Action' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $data as $entry ) : ?>
							<tr>
								<td><?php echo $entry['ComplianceFinding']['title']; ?></td>
								<td><?php echo $entry['ComplianceFinding']['description']; ?></td>
								<td><?php echo $entry['ComplianceFinding']['deadline']; ?></td>
								<td><?php echo $entry['ComplianceFindingStatus']['name']; ?></td>
								<td class="align-center">
									<?php echo $this->element( 'action_buttons', array( 
										'id' => $entry['ComplianceFinding']['id'],
										'controller' => 'complianceFindings'
									) ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
			<?php else : ?>
				<?php echo $this->element( 'not_found', array(
					'message' => __( 'No Compliance Findings found.' )
				) ); ?>
			<?php endif; ?>

		</div>
	</div>

</div>