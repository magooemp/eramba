<?php
class AssetLabelsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Asset Labeling Classifications' ) );
		$this->set( 'subtitle_for_layout', __( 'Define how you would like assets to be labeled.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				'AssetLabel.id', 'AssetLabel.name', 'AssetLabel.description'
			),
			'order' => array('AssetLabel.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'AssetLabel' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->AssetLabel->find( 'count', array(
			'conditions' => array(
				'AssetLabel.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->AssetLabel->delete( $id );

		$this->Session->setFlash( __( 'Asset Label was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'assetLabels', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create an Asset Label Classification' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['AssetLabel']['id'] );

			$this->AssetLabel->set( $this->request->data );

			if ( $this->AssetLabel->validates() ) {
				if ( $this->AssetLabel->save() ) {
					$this->Session->setFlash( __( 'Asset Label Classification was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'assetLabels', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['AssetLabel']['id'];
		}

		$data = $this->AssetLabel->find( 'first', array(
			'conditions' => array(
				'AssetLabel.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit an Asset Label Classification' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->AssetLabel->set( $this->request->data );

			if ( $this->AssetLabel->validates() ) {
				if ( $this->AssetLabel->save() ) {
					$this->Session->setFlash( __( 'Asset Label Classification was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'assetLabels', 'action' => 'index', $id ) );
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

		$this->render( 'add' );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Define your Security Incident Classification.' ) );
	}

}
?>