<?php

/**
 * Acci�n para editar un paciente.
 *
 * @author modelBuilder
 * @since 12-12-2011
 *
 */
abstract class EditarPacienteAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){

		//se construye el paciente a modificar.
		$oPaciente = new Paciente ( );


		$oPaciente->setCd_paciente ( FormatUtils::getParamPOST('cd_paciente') );

		$oPaciente->setDs_apynom ( FormatUtils::getParamPOST('ds_apynom') );

		$oPaciente->setCd_tipodoc ( FormatUtils::getParamPOST('cd_tipodoc') );

		$oPaciente->setNu_doc ( FormatUtils::getParamPOST('nu_doc') );

		$oPaciente->setDs_direccion ( FormatUtils::getParamPOST('ds_direccion') );

		$oPaciente->setDs_telefono ( FormatUtils::getParamPOST('ds_telefono') );

		$oPaciente->setDs_email ( FormatUtils::getParamPOST('ds_email') );

		$oPaciente->setDt_nacimiento(FuncionesComunes::fechaPHPaMysql(FormatUtils::getParamPOST('dt_nacimiento')));

        $oPaciente->setCd_medio(FormatUtils::getParamPOST('cd_medio'));

        $oPaciente->setDs_otroMedio(FormatUtils::getParamPOST('ds_otroMedio'));

		return $oPaciente;
	}


}
