<?php
class AssetsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Asset Identification' ) );
		$this->set( 'subtitle_for_layout', __( 'Build a list of significant assets for your security program.' ) );

		$this->paginate = array(
			'conditions' => array(
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

	public function delete( $id = null ) {
		$data = $this->Asset->find( 'count', array(
			'conditions' => array(
				'Asset.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->Asset->delete( $id );
		$this->Asset->AssetsBusinessUnit->deleteAll( array(
			'AssetsBusinessUnit.asset_id' => $id
		) );

		$this->Session->setFlash( __( 'Asset was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'assets', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create an Asset' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['Asset']['id'] );

			$this->Asset->set( $this->request->data );

			if ( $this->Asset->validates() ) {
				if ( $this->Asset->save() ) {

					$this->joinAssetsBusinessUnits( $this->request->data['Asset']['business_unit_id'], $this->Asset->id );

					$this->Session->setFlash( __( 'Asset was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'assets', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}

		$this->initOptions();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['Asset']['id'];
		}

		$data = $this->Asset->find( 'first', array(
			'conditions' => array(
				'Asset.id' => $id
			),
			'recursive' => 1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit an Asset' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->Asset->set( $this->request->data );

			if ( $this->Asset->validates() ) {
				if ( $this->Asset->save() ) {
					$this->Asset->AssetsBusinessUnit->deleteAll( array(
						'AssetsBusinessUnit.asset_id' => $id
					) );

					$this->joinAssetsBusinessUnits( $this->request->data['Asset']['business_unit_id'], $this->Asset->id );

					$this->Session->setFlash( __( 'Asset was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'assets', 'action' => 'index', $id ) );
				}
				else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
		else {
			$this->request->data = $data;
		}

		$this->initOptions();
		$this->render( 'add' );
	}

	private function joinAssetsBusinessUnits( $bu_list, $asset_id ) {
		foreach ( $bu_list as $bu_id ) {
			$tmp = array(
				'asset_id' => $asset_id,
				'business_unit_id' => $bu_id
			);

			$this->Asset->AssetsBusinessUnit->create();
			$this->Asset->AssetsBusinessUnit->save( $tmp );
		}
	}

	private function initOptions() {
		$bu_list = $this->Asset->BusinessUnit->find('list', array(
			'order' => array('BusinessUnit.name' => 'ASC'),
			'recursive' => -1
		));

		$media_types = $this->Asset->AssetMediaType->find('list', array(
			'order' => array('AssetMediaType.name' => 'ASC'),
			'recursive' => -1
		));

		$labels = $this->Asset->AssetLabel->find('list', array(
			'order' => array('AssetLabel.name' => 'ASC'),
			'recursive' => -1
		));

		$legals = $this->Asset->Legal->find('list', array(
			'order' => array('Legal.name' => 'ASC'),
			'recursive' => -1
		));
		
		$this->set( 'bu_list', $bu_list );
		$this->set( 'media_types', $media_types );
		$this->set( 'labels', $labels );
		$this->set( 'legals', $legals );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Identifing assets is perhaps one of the most important tasks for a Security Program. It all revolves around understanding what is that the program intends to protect. You might need to ask yourselfeve the 5w + 1H (Why, Where, What, When, Who and How!) for each single piece of assets it\'s reasonable to spend time with.' ) );
	}

}
?>