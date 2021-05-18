<?php

/**
 * Acci�n para visualizar un medio.
 *
 * @author modelBuilder
 * @since 18-05-2021
 *
 */
class VerMedioAction extends OutputAction{

	/**
	 * consulta un medio.
	 */
	protected function getContenido(){

		$xtpl = $this->getXTemplate ();

		if (isset ( $_GET ['id'] )) {
			$cd_medio = FormatUtils::getParam('id');


			try{
				$id = FormatUtils::getParam('id');

				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_medio', $id, '=');

				$manager = new MedioManager();
				$oMedio = $manager->getMedio( $criterio );

			}catch(GenericException $ex){
				$oMedio = new Medio();
				//TODO ver si se muestra un mensaje de error.
			}

			//se muestra el medio.
			$this->parseEntidad( $xtpl, $oMedio );


		}

		$xtpl->assign ( 'titulo', 'Detalle de Tipo de Documento' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Tipo de Documento";
	}

	public function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_VER_MEDIO );
	}

	public function parseEntidad($xtpl, $oMedio){


		$xtpl->assign ( 'cd_medio', stripslashes ( $oMedio->getCd_medio () ) );
		$xtpl->assign ( 'cd_medio_label', RYT_MEDIO_CD_MEDIO );

		$xtpl->assign ( 'ds_medio', stripslashes ( $oMedio->getDs_medio () ) );
		$xtpl->assign ( 'ds_medio_label', RYT_MEDIO_DS_MEDIO );


	}
}
