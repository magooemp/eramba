<?php
class AssetClassificationsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Asset Classification' ) );
		$this->set( 'subtitle_for_layout', __( 'You\'ll be classifying assets very soon, it\'s very important you decide a classification method that fits you the best. Keep in mind it must be usefull!' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				'AssetClassification.id',
				'AssetClassification.name',
				'AssetClassification.criteria',
				'AssetClassificationType.name'
			),
			'order' => array('AssetClassification.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'AssetClassification' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->AssetClassification->find( 'count', array(
			'conditions' => array(
				'AssetClassification.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->AssetClassification->delete( $id ) ) {
			$this->Session->setFlash( __( 'Asset Classification was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'assetClassifications', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create an Asset Classification' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['AssetClassification']['id'] );

			$this->processSubmit( __( 'Asset Classification was successfully added.' ) );
		}

		$this->initOptions();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['AssetClassification']['id'];
		}

		$data = $this->AssetClassification->find( 'first', array(
			'conditions' => array(
				'AssetClassification.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit an Asset Classification' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {
			$this->processSubmit( __( 'Asset Classification was successfully edited.' ) );
		}
		else {
			$this->request->data = $data;
		}

		$this->initOptions();
		$this->render( 'add' );
	}

	private function processSubmit( $flashMessage = '' ) {
		if ( $this->request->data['AssetClassification']['asset_classification_type_id'] == '' ) {

			$this->AssetClassification->set( $this->request->data );
			$this->AssetClassification->AssetClassificationType->set( $this->request->data );

			if ( $this->AssetClassification->AssetClassificationType->validates() &&
				$this->AssetClassification->validates()	) {

				$this->AssetClassification->query( 'SET autocommit = 0' );
				$this->AssetClassification->begin();

				if ( $this->AssetClassification->AssetClassificationType->save() ) {

					$this->request->data['AssetClassification']['asset_classification_type_id'] = $this->AssetClassification->AssetClassificationType->id;
					$this->AssetClassification->set( $this->request->data );

					if ( $this->AssetClassification->save() ) {
						$this->AssetClassification->commit();

						$this->Session->setFlash( $flashMessage, FLASH_OK );
						$this->redirect( array( 'controller' => 'assetClassifications', 'action' => 'index' ) );
					} else {
						$this->AssetClassification->rollback();
						$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
					}
				} else {
					$this->AssetClassification->rollback();
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}

			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}

		} else {
			$this->AssetClassification->set( $this->request->data );

			if ( $this->AssetClassification->validates() ) {
				if ( $this->AssetClassification->save() ) {
					$this->Session->setFlash( __( 'Asset Classification was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'assetClassifications', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Usually there\'s many assets around in a organization. Trough classification (according to your needs) you will be able to set priorities and profile them in a way their treatment and handling is systematic. Btw, this is a basic requirement for most Security related regulations.' ) );
	}

	private function initOptions() {
		$ac_types = $this->AssetClassification->AssetClassificationType->find('list', array(
			'order' => array('AssetClassificationType.name' => 'ASC'),
			'recursive' => -1
		));

		$this->set( 'ac_types', $ac_types );
	}

}
?>