<?php

/**
 * Autogenerated class
 *
 *  @author modelBuilder
 *  @since 18-05-2021
 */
class MedioFactory extends GenericFactory{

	public function build($next) {
		$this->setClassName('Medio');
		$oMedio = parent::build($next);

		 //TODO foreign keys

		return $oMedio;
	}
}
?>
