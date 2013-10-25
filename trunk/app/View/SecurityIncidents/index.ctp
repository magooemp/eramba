<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'securityIncidents',
						'action' => 'add'
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
							<th><?php echo $this->Paginator->sort( 'SecurityIncident.title', __( 'Title' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'ThirdParty.name', __( 'Third Party' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'SecurityIncident.reporter', __( 'Reporter' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'SecurityIncident.victim', __( 'Affected' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'SecurityIncident.owner', __( 'Owner' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'SecurityIncidentClassification.name', __( 'Classification' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'SecurityIncidentStatus.name', __( 'Status' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'SecurityIncident.open_date', __( 'Open Date' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'SecurityIncident.closure_date', __( 'Closure Date' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'Asset.name', __( 'Asset' ) ); ?></th>
							<th class="align-center"><?php echo __( 'Action' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $data as $entry ) : ?>
							<tr>
								<td><?php echo $entry['SecurityIncident']['title']; ?></td>
								<td><?php echo $entry['ThirdParty']['name']; ?></td>
								<td><?php echo $entry['SecurityIncident']['reporter']; ?></td>
								<td><?php echo $entry['SecurityIncident']['victim']; ?></td>
								<td><?php echo $entry['SecurityIncident']['owner']; ?></td>
								<td><?php echo $entry['SecurityIncidentClassification']['name']; ?></td>
								<td><?php echo $entry['SecurityIncidentStatus']['name']; ?></td>
								<td><?php echo $entry['SecurityIncident']['open_date']; ?></td>
								<td><?php echo $entry['SecurityIncident']['closure_date']; ?></td>
								<td><?php echo $entry['Asset']['name']; ?></td>
								<td class="align-center">
									<?php echo $this->element( 'action_buttons', array( 
										'id' => $entry['SecurityIncident']['id'],
										'controller' => 'securityIncidents'
									) ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
			<?php else : ?>
				<?php echo $this->element( 'not_found', array(
					'message' => __( 'No Security Incidents found.' )
				) ); ?>
			<?php endif; ?>

		</div>
	</div>

</div>