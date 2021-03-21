<?php

/**
 * Acción para inicializar el contexto para dar de alta
 * un movcaja.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class AltaMovcajaInitAction extends EditarMovcajaInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return "Alta Movimiento caja";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
     */
    protected function getAccionSubmit() {
        return "alta_movcaja";
    }

    function getEntidad() {
        $oEntidad = parent::getEntidad();
        unset($_SESSION['movcajaconceptos_session']);
        //Obtengo la caja del usuario actual
        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);
        $oEntidad->setCd_usuario($cd_usuario);
        $oEntidad->setNu_caja($oUsuario->getNu_caja());
        //Obtengo el turno de la última caja abierta
        $movcajaManager = new MovcajaManager();
        $rta = $movcajaManager->hayCajaAbierta($oUsuario->getNu_caja());
        $cd_concepto = $rta['cd_concepto'];
        $cd_movcaja = $rta['cd_movcaja'];
        $cd_turno = $rta['cd_turno'];
        $nu_caja_abierta = $rta['nu_caja'];
        $oEntidad->setCd_turno($cd_turno);

        $fechayhora = date('YmdHis');
        $oEntidad->setDt_movcaja($fechayhora);
        return $oEntidad;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
     */
    protected function getMostrarCodigo() {
        return false;
    }

}
