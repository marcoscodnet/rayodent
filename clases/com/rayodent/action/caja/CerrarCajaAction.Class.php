<?php

/**
 * Apertura de caja: abre una caja ingresando turno y un importe inicial (el importe se lo dejan apartado y sirve para cambio).
  Esto genera una transferencia de la caja central a la caja del usuario, mediante dos movimientos de caja.
  1-  Un movimiento con tipo concepto ?Caja? y Concepto ?Extracción caja central? por el monto ingresado. (Esto se haría creando un movcaja, con nu caja 100 q es la caja central)

  2-  Un movimiento con tipo concepto ?Caja? y Concepto ?Ingreso? por el monto ingresado.
  (Esto se haría creando un movcaja, con el nu caja el del usuario + monto)

 *
 */
class CerrarCajaAction extends EditarAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        unset($_SESSION['movcajaconceptos_session']);
        $movcajaManager = new MovcajaManager();
        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("cd_usuario", $cd_usuario, "=");
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuario($criterio);
        $nu_caja = $oUsuario->getNu_caja();
        $rta = $movcajaManager->hayCajaAbierta($nu_caja);
        if (isset($rta['cd_movcaja']) && ($rta['cd_movcaja'] != "")) {

            //$oEntidad es un objeto procesocaja
            //Creo el movimiento de caja para la caja del usuario
            $oMovcajaUsuario = new Movcaja();
            $oMovcajaUsuario->setCd_turno($oEntidad->getCd_turno());
            $oMovcajaUsuario->setCd_usuario($oEntidad->getCd_usuario());
            $oMovcajaUsuario->setDs_observacion("Cierre de Caja");
            $oMovcajaUsuario->setDt_movcaja($oEntidad->getDt_procesocaja());
            $oMovcajaUsuario->setNu_caja($oEntidad->getNu_caja());
            $oMovcajaManager = new MovcajaManager();
            $oMovcajaManager->agregarMovcaja($oMovcajaUsuario);

            //guardo el proceso de caja asociado a la apertura del usuario
            $oProcesocajaManager = new ProcesocajaManager();
            $oEntidad->setCd_movcaja($oMovcajaUsuario->getCd_movcaja());
            $oProcesocajaManager->agregarProcesocaja($oEntidad);

            //Creo el movimiento de caja para la caja central
            $oMovcajaCentral = clone($oMovcajaUsuario);
            $oMovcajaCentral->setNu_caja(NU_CAJA_CAJA_CENTRAL);
            $oMovcajaCentral->setCd_usuario(CD_USUARIO_CAJA_CENTRAL);
            $oMovcajaCentral->setDs_observacion("Cierre de Caja Nro.:" . $oMovcajaUsuario->getNu_caja());
            $oMovcajaManager->agregarMovcaja($oMovcajaCentral);

            /* +------------------------------------------------------+
             * *| Almaceno los conceptos aociados al movimiento de caja|
             * +------------------------------------------------------+
             */

            $oMovcajaconceptoUsuario = new Movcajaconcepto();
            $oMovcajaconceptoUsuario->setCd_movcaja($oMovcajaUsuario->getCd_movcaja());
            $oMovcajaconceptoUsuario->setNu_importe($oEntidad->getNu_importe());
            $oMovcajaconceptoUsuario->setCd_concepto(CD_CONCEPTO_EGRESO_CIERRE);
            $oMovcajaconceptoManager = new MovcajaconceptoManager();
            $oMovcajaconceptoManager->agregarMovcajaconcepto($oMovcajaconceptoUsuario);


            $oMovcajaconceptoCentral = new Movcajaconcepto();
            $oMovcajaconceptoCentral->setCd_movcaja($oMovcajaCentral->getCd_movcaja());
            $oMovcajaconceptoCentral->setNu_importe($oEntidad->getNu_importe());
            $oMovcajaconceptoCentral->setCd_concepto(CD_CONCEPTO_INGRESO_CAJA_CENTRAL);
            $oMovcajaconceptoManager = new MovcajaconceptoManager();
            $oMovcajaconceptoManager->agregarMovcajaconcepto($oMovcajaconceptoCentral);
            $this->setDs_forward_params("msg= Se ha registrado el cierre de caja correctamente");
        } else {
            $this->setDs_forward_params("msg= Sorry,no hay una caja abierta");
        }
    }

    protected function getEntidad() {

        //El usuario eligió turno, importa, caja, usuario
        //se construye el movcaja a modificar.
        $oProcesocaja = new Procesocaja ( );

        //Obtengo la caja del usuario actual
        $cd_usuario = $_SESSION['cd_usuarioSession'];

        $oProcesocaja->setCd_usuario($cd_usuario);
        $oProcesocaja->setNu_caja(FormatUtils::getParamPOST('nu_caja'));
        $oProcesocaja->setNu_importe(FormatUtils::getParamPOST('nu_importe'));
        $oProcesocaja->setCd_turno(FormatUtils::getParamPOST('cd_turno'));
        $hoyyahora = date('YmdHis');
        $oProcesocaja->setDt_procesocaja($hoyyahora);

        return $oProcesocaja;
    }

    protected function getForwardSuccess() {
        return 'cerrar_caja_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'cerrar_caja_error';
    }

    protected function getActionForwardFailure() {
        return 'cerrar_caja_init';
    }

}
