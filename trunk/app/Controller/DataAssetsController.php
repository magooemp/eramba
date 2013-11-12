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
				'Asset.asset_media_type_id' => ASSET_MEDIA_TYPE_DATA
			),
			'contain' => array(
				'DataAsset' => array(
					'fields' => array( 'id', 'description' ),
					'DataAssetStatus' => array(
						'fields' => array( 'id', 'name' )
					),
					'SecurityService' => array(
						'fields' => array( 'id', 'name' )
					)
				)
			),
			'fields' => array(
				'Asset.id', 'Asset.name'
			),
			'order' => array('Asset.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 2
		);

		$data = $this->paginate( 'Asset' );
		$this->set( 'data', $data );
	}

	public function add( $asset_id = null ) {
		$asset_id = (int) $asset_id;

		$this->set( 'title_for_layout', __( 'Analyse a Data Asset' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['DataAsset']['id'] );

			$this->DataAsset->set( $this->request->data );

			if ( $this->DataAsset->validates() ) {
				$this->DataAsset->query( 'SET autocommit = 0' );
				$this->DataAsset->begin();

				$save1 = $this->DataAsset->save();
				$save2 = $this->joinSecurityServices( $this->request->data['DataAsset']['security_service_id'], $this->DataAsset->id );
				$save3 = $this->joinBusinessUnits( $this->request->data['DataAsset']['business_unit_id'], $this->DataAsset->id );
				$save4 = $this->joinThirdParties( $this->request->data['DataAsset']['third_party_id'], $this->DataAsset->id );

				if ( $save1 && $save2 && $save3 && $save4 ) {
					$this->DataAsset->commit();

					$this->Session->setFlash( __( 'Data Asset was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'dataAssets', 'action' => 'index' ) );
				} else {
					$this->DataAsset->rollback();

					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}

		$this->set( 'asset_id', $asset_id );

		$this->initOptions();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['DataAsset']['id'];
		}

		$data = $this->DataAsset->find( 'first', array(
			'conditions' => array(
				'DataAsset.id' => $id
			),
			'recursive' => 1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'asset_id', $data['DataAsset']['asset_id'] );

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Analyse a Data Asset' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->DataAsset->set( $this->request->data );

			if ( $this->DataAsset->validates() ) {
				$this->DataAsset->query( 'SET autocommit = 0' );
				$this->DataAsset->begin();

				$delete = $this->deleteJoins( $id );
				$save1 = $this->DataAsset->save();
				$save2 = $this->joinSecurityServices( $this->request->data['DataAsset']['security_service_id'], $this->DataAsset->id );
				$save3 = $this->joinBusinessUnits( $this->request->data['DataAsset']['business_unit_id'], $this->DataAsset->id );
				$save4 = $this->joinThirdParties( $this->request->data['DataAsset']['third_party_id'], $this->DataAsset->id );

				if ( $delete && $save1 && $save2 && $save3 && $save4 ) {
					$this->DataAsset->commit();

					$this->Session->setFlash( __( 'Data Asset was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'dataAssets', 'action' => 'index' ) );
				} else {
					$this->DataAsset->rollback();

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

	/**
	 * Join Security Services.
	 */
	private function joinSecurityServices( $list, $data_asset_id ) {
		if ( ! is_array( $list ) ) {
			return true;
		}

		foreach ( $list as $id ) {
			$tmp = array(
				'data_asset_id' => $data_asset_id,
				'security_service_id' => $id
			);

			$this->DataAsset->DataAssetsSecurityService->create();
			if ( ! $this->DataAsset->DataAssetsSecurityService->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Business Units.
	 */
	private function joinBusinessUnits( $list, $data_asset_id ) {
		if ( ! is_array( $list ) ) {
			return true;
		}

		foreach ( $list as $id ) {
			$tmp = array(
				'data_asset_id' => $data_asset_id,
				'business_unit_id' => $id
			);

			$this->DataAsset->BusinessUnitsDataAsset->create();
			if ( ! $this->DataAsset->BusinessUnitsDataAsset->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Third Parties.
	 */
	private function joinThirdParties( $list, $data_asset_id ) {
		if ( ! is_array( $list ) ) {
			return true;
		}

		foreach ( $list as $id ) {
			$tmp = array(
				'data_asset_id' => $data_asset_id,
				'third_party_id' => $id
			);

			$this->DataAsset->DataAssetsThirdParty->create();
			if ( ! $this->DataAsset->DataAssetsThirdParty->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Delete all many to many joins in related tables.
	 * @param integer $id Data Asset ID.
	 */
	private function deleteJoins( $id ) {
		$delete1 = $this->DataAsset->DataAssetsSecurityService->deleteAll( array(
			'DataAssetsSecurityService.data_asset_id' => $id
		) );

		$delete2 = $this->DataAsset->BusinessUnitsDataAsset->deleteAll( array(
			'BusinessUnitsDataAsset.data_asset_id' => $id
		) );

		$delete3 = $this->DataAsset->DataAssetsThirdParty->deleteAll( array(
			'DataAssetsThirdParty.data_asset_id' => $id
		) );

		if ( $delete1 && $delete2 && $delete3 ) {
			return true;
		}

		return false;
	}

	private function initOptions() {
		$statuses = $this->DataAsset->DataAssetStatus->find('list', array(
			'order' => array('DataAssetStatus.name' => 'ASC'),
			'recursive' => -1
		));

		$services = $this->DataAsset->SecurityService->find('list', array(
			'order' => array('SecurityService.name' => 'ASC'),
			'recursive' => -1
		));

		$business_units = $this->DataAsset->BusinessUnit->find('list', array(
			'order' => array('BusinessUnit.name' => 'ASC'),
			'recursive' => -1
		));

		$third_parties = $this->DataAsset->ThirdParty->find('list', array(
			'order' => array('ThirdParty.name' => 'ASC'),
			'recursive' => -1
		));
		
		$this->set( 'statuses', $statuses );
		$this->set( 'services', $services );
		$this->set( 'business_units', $business_units );
		$this->set( 'third_parties', $third_parties );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'In the end, is your core data assets that you struggle to protect every day, isnt it?. It\'s important you identify for each data asset status (creation, modification, storage, transit and deletion) how those assets are protected.' ) );
	}

}