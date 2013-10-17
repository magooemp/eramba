<?php
class DataAssetsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Data Asset Analysis' ) );
		$this->set( 'subtitle_for_layout', __( 'For those sensitive data assets, describe the process on how they are created, used, transmited and disposed in order to ensure correct controls are in place for each one of those phases of the lifecycle of an asset.' ) );

		$this->loadModel( 'Asset' );
		$this->paginate = array(
			'conditions' => array(
				'Asset.asset_media_type_id' => 1
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('Asset.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'Asset' );
		$this->set( 'data', $data );
	}
}