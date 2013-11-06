<?php
class CompliancePackageItemsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function delete( $id = null ) {
		$data = $this->CompliancePackageItem->find( 'count', array(
			'conditions' => array(
				'CompliancePackageItem.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->CompliancePackageItem->delete( $id ) ) {
			$this->Session->setFlash( __( 'Compliance Package Item was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'compliancePackages', 'action' => 'index' ) );
	}

	public function add( $cp_id = null ) {
		$cp_id = (int) $cp_id;

		$this->set( 'title_for_layout', __( 'Create a Compliance Package Item' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['CompliancePackageItem']['id'] );

			$this->CompliancePackageItem->set( $this->request->data );

			if ( $this->CompliancePackageItem->validates() ) {
				if ( $this->CompliancePackageItem->save() ) {
					$this->Session->setFlash( __( 'Compliance Package Item was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'compliancePackages', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		} else {
			$cp_data = $this->CompliancePackageItem->CompliancePackage->find( 'first', array(
				'conditions' => array(
					'CompliancePackage.id' => $cp_id
				),
				'recursive' => -1
			) );

			if ( empty( $cp_data ) ) {
				throw new NotFoundException();
			}
		}

		$this->set( 'cp_id', $cp_id );
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['CompliancePackageItem']['id'];
		}

		$data = $this->CompliancePackageItem->find( 'first', array(
			'conditions' => array(
				'CompliancePackageItem.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Compliance Package Item' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->CompliancePackageItem->set( $this->request->data );

			if ( $this->CompliancePackageItem->validates() ) {
				
				if ( $this->CompliancePackageItem->save() ) {
					$this->Session->setFlash( __( 'Compliance Package Item was successfully edited.' ), FLASH_OK );
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

		$this->render( 'add' );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', false );
	}

}