<?php
class AssetsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Asset Identification' ) );
		$this->set( 'subtitle_for_layout', __( 'Build a list of significant assets for your security program.' ) );

		$this->loadModel( 'BusinessUnit' );
		$this->paginate = array(
			'conditions' => array(
			),
			'contain' => array(
				'Asset' => array(
					'fields' => array( 'id', 'name', 'description', 'asset_owner_id', 'asset_guardian_id', 'asset_user_id' ),
					'AssetMediaType' => array(
						'fields' => array( 'name' )
					),
					'AssetLabel' => array(
						'fields' => array( 'name' )
					),
					'Legal' => array(
						'fields' => array( 'name' )
					),
					'AssetClassification' => array(
						'AssetClassificationType' => array()
					),
					'AssetOwner' => array(
						'fields' => array( 'name' )
					),
					'AssetGuardian' => array(
						'fields' => array( 'name' )
					),
					'AssetUser' => array(
						'fields' => array( 'name' )
					),
					'AssetMainContainer' => array(
						'fields' => array( 'name' )
					),
					'SecurityIncident' => array()
				),
			),
			'fields' => array(
				'BusinessUnit.id',
				'BusinessUnit.name'
			),
			'order' => array('BusinessUnit.id' => 'ASC'),
			//'limit' => $this->getPageLimit(),
			'recursive' => 2
		);

		$data = $this->paginate( 'BusinessUnit' );
		$this->set( 'data', $data );

		//debug( $data );
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

		$this->Asset->query( 'SET autocommit = 0' );
		$this->Asset->begin();

		$delete1 = $this->Asset->delete( $id );
		$delete2 = $this->Asset->AssetsBusinessUnit->deleteAll( array(
			'AssetsBusinessUnit.asset_id' => $id
		) );

		if ( $delete1 && $delete2 ) {
			$this->Asset->commit();
			$this->Session->setFlash( __( 'Asset was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
			$this->Asset->rollback();
		}
		
		$this->redirect( array( 'controller' => 'assets', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create an Asset' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['Asset']['id'] );

			$this->Asset->set( $this->request->data );

			if ( $this->Asset->validates() ) {
				$this->Asset->query( 'SET autocommit = 0' );
				$this->Asset->begin();

				$save1 = $this->Asset->save();
				$save2 = $this->joinAssetsBusinessUnits( $this->request->data['Asset']['business_unit_id'], $this->Asset->id );
				$save3 = $this->joinAssetClassifications( $this->request->data['Asset']['asset_classification_id'], $this->Asset->id );

				if ( $save1 && $save2 & $save3 ) {
					$this->Asset->commit();

					$this->Session->setFlash( __( 'Asset was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'assets', 'action' => 'index' ) );
				} else {
					$this->Asset->rollback();
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
				$this->Asset->query( 'SET autocommit = 0' );
				$this->Asset->begin();

				$save1 = $this->Asset->save();
				$delete = $this->Asset->AssetsBusinessUnit->deleteAll( array(
					'AssetsBusinessUnit.asset_id' => $id
				) );
				$delete2 = $this->Asset->AssetClassificationsAsset->deleteAll( array(
					'AssetClassificationsAsset.asset_id' => $id
				) );
				$save2 = $this->joinAssetsBusinessUnits( $this->request->data['Asset']['business_unit_id'], $this->Asset->id );
				$save3 = $this->joinAssetClassifications( $this->request->data['Asset']['asset_classification_id'], $this->Asset->id );

				if ( $save1 && $delete && $delete2 && $save2 && $save3 ) {
					$this->Asset->commit();

					$this->Session->setFlash( __( 'Asset was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'assets', 'action' => 'index', $id ) );
				}
				else {
					$this->Asset->rollback();
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

	private function joinAssetsBusinessUnits( $list, $asset_id ) {
		if ( ! is_array( $list ) ) {
			return true;
		}
		
		foreach ( $list as $bu_id ) {
			$tmp = array(
				'asset_id' => $asset_id,
				'business_unit_id' => $bu_id
			);

			$this->Asset->AssetsBusinessUnit->create();
			if ( ! $this->Asset->AssetsBusinessUnit->save( $tmp ) ) {
				return false;
			}
		}
		return true;
	}

	private function joinAssetClassifications( $list, $asset_id ) {
		if ( ! is_array( $list ) ) {
			return true;
		}
		
		foreach ( $list as $asset_classification_id ) {
			if ( ! $asset_classification_id )
				continue;

			$tmp = array(
				'asset_id' => $asset_id,
				'asset_classification_id' => $asset_classification_id
			);

			$this->Asset->AssetClassificationsAsset->create();
			if ( ! $this->Asset->AssetClassificationsAsset->save( $tmp ) ) {
				return false;
			}
		}
		return true;
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

		$this->loadModel( 'AssetClassificationType' );
		$classifications = $this->AssetClassificationType->find('all', array(
			'order' => array('AssetClassificationType.name' => 'ASC'),
			'recursive' => 1
		));

		$assets = $this->Asset->find('list', array(
			'order' => array('Asset.name' => 'ASC'),
			'recursive' => -1
		));
		
		$this->set( 'bu_list', $bu_list );
		$this->set( 'media_types', $media_types );
		$this->set( 'labels', $labels );
		$this->set( 'legals', $legals );
		$this->set( 'classifications', $classifications );
		$this->set( 'assets', $assets );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Identifing assets is perhaps one of the most important tasks for a Security Program. It all revolves around understanding what is that the program intends to protect. You might need to ask yourselfeve the 5w + 1H (Why, Where, What, When, Who and How!) for each single piece of assets it\'s reasonable to spend time with.' ) );
	}

}
?>