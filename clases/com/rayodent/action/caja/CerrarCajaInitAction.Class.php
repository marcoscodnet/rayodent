<?php

/**
 * Acción para inicializar el contexto para dar de alta
 * un movcaja.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class CerrarCajaInitAction extends EditarInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return "Cierre de Caja";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
     */
    protected function getAccionSubmit() {
        return "cerrar_caja";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
     */
    protected function getMostrarCodigo() {
        return false;
    }

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_CERRAR_CAJA);
    }

    protected function getEntidad() {
        //se construye el movcaja a modificar.
        $oMovcaja = new Movcaja ( );
        return $oMovcaja;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
     */
    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("cd_usuario", $cd_usuario, "=");
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuario($criterio);
        $nu_caja = $oUsuario->getNu_caja();
        $xtpl->assign('nu_caja', $nu_caja);
        $xtpl->assign('nu_caja_label', RYT_MOVCAJA_NU_CAJA);
        $xtpl->assign('cd_turno_label', RYT_MOVCAJA_CD_TURNO);
        $xtpl->assign('nu_importe_label', RYT_MOVCAJA_NU_IMPORTE);
        if ($nu_caja != "" && $nu_caja != null) {
            $movcajaManager = new MovcajaManager();
            $rta = $movcajaManager->hayCajaAbierta($nu_caja);
            $cd_concepto = $rta['cd_concepto'];
            $cd_movcaja = $rta['cd_movcaja'];
            $cd_turno = $rta['cd_turno'];
            $nu_caja_abierta = $rta['nu_caja'];
            $cd_usuario_caja_abierta = $rta['cd_usuario'];
            $oUsuarioCajaAbierta = $usuarioManager->getUsuarioPorId($cd_usuario_caja_abierta);
            if ($cd_concepto == CD_CONCEPTO_INGRESO) {
                //Si hay caja Abierta, recupero el total
                $criterio = new CriterioBusqueda ();
                $criterio->addFiltro("CA.cd_movcaja", $cd_movcaja, ">=");
                //$criterio->addFiltro("CA.nu_caja", $oUsuario->getNu_caja(), "=");
                $criterio->addFiltro("CA.nu_caja", NU_CAJA_CAJA_CENTRAL, "<>");
                $monto = $movcajaManager->getMontoTotal($criterio);
                $xtpl->assign('nu_importe', $monto);
                $xtpl->assign('cd_turno', $cd_turno);

                //Recupero la descripciï¿½n del cd_turno
                $criterio = new CriterioBusqueda ();
                $criterio->addFiltro('cd_turno', $cd_turno, "=");
                $oTurnoManager = new TurnoManager ();
                $oTurno = $oTurnoManager->getTurno($criterio);
                $xtpl->assign('ds_turno', $oTurno->getDs_turno());
                if ($nu_caja_abierta != $nu_caja) {
                    $msj_html = "ERROR: Actualmente Ud no tiene una caja abierta. La caja abierta es la NÂº $nu_caja_abierta del usuario " . $oUsuarioCajaAbierta->getDs_nomusuario();
                    $xtpl->assign('msj', $msj_html);
                    $xtpl->parse("main.msj");
                } else {
                    $xtpl->parse("main.boton_aceptar");
                }
            } else {
                $xtpl->assign('msj', "ERROR: no hay una caja abierta");
                $xtpl->parse("main.msj");
            }
        }
    }

}

