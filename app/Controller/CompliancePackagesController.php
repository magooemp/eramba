<?php
class CompliancePackagesController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Compliance Package Database' ) );
		$this->set( 'subtitle_for_layout', __( 'Most security organizations are subject to multiple compliances (or they set regulations to other partners). A key starting point in defining a Compliance Program is defining what exact regulations (compliance packages) and requirements (compliance packages items) your security program is subject to.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				'ThirdParty.id', 'ThirdParty.name'
			),
			'contain' => array(
				'CompliancePackage' => array(
					'CompliancePackageItem' => array(
						'fields' => array( 'id', 'item_id', 'name', 'description' )
					)
				)
			),
			'order' => array('ThirdParty.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 2
		);

		$data = $this->paginate( 'ThirdParty' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->CompliancePackage->find( 'count', array(
			'conditions' => array(
				'CompliancePackage.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->CompliancePackage->delete( $id ) ) {
			$this->Session->setFlash( __( 'Compliance Package was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'compliancePackages', 'action' => 'index' ) );
	}

	public function add( $tp_id = null ) {
		$this->set( 'title_for_layout', __( 'Create a Compliance Package' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['CompliancePackage']['id'] );

			$this->CompliancePackage->set( $this->request->data );

			if ( $this->CompliancePackage->validates() ) {
				if ( $this->CompliancePackage->save() ) {
					$this->Session->setFlash( __( 'Compliance Package was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'compliancePackages', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}

		$this->set( 'selected', $tp_id );

		$this->initOptions();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['CompliancePackage']['id'];
		}

		$data = $this->CompliancePackage->find( 'first', array(
			'conditions' => array(
				'CompliancePackage.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Compliance Package' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->CompliancePackage->set( $this->request->data );

			if ( $this->CompliancePackage->validates() ) {
				if ( $this->CompliancePackage->save() ) {
					$this->Session->setFlash( __( 'Compliance Package was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'compliancePackages', 'action' => 'index', $id ) );
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

	/**
	 * Initialize options for join elements.
	 */
	private function initOptions() {
		$third_parties = $this->CompliancePackage->ThirdParty->find('list', array(
			'order' => array('ThirdParty.name' => 'ASC'),
			'recursive' => -1
		));

		$this->set( 'third_parties', $third_parties );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', false );
	}

}
?>