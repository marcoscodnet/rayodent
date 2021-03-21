<?php

/**
 * AcciÃ³n para inicializar el contexto para dar de alta
 * un movcaja.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class AbrirCajaInitAction extends EditarInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return "Apertura de Caja";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
     */
    protected function getAccionSubmit() {
        return "abrir_caja";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
     */
    protected function getMostrarCodigo() {
        return false;
    }

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_ABRIR_CAJA);
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

        $movcajaManager = new MovcajaManager();
        $rta = $movcajaManager->hayCajaAbierta($nu_caja);
        $cd_concepto = $rta['cd_concepto'];
        $cd_movcaja = $rta['cd_movcaja'];
        $cd_turno = $rta['cd_turno'];
        $nu_caja_abierta = $rta['nu_caja'];

        $cd_usuario_caja_abierta = $rta['cd_usuario'];
        $oUsuarioCajaAbierta = $usuarioManager->getUsuarioPorId($cd_usuario_caja_abierta);

        $xtpl->assign('nu_caja_label', RYT_MOVCAJA_NU_CAJA);
        $xtpl->assign('cd_turno_label', RYT_MOVCAJA_CD_TURNO);
        $xtpl->assign('nu_importe_label', RYT_MOVCAJA_NU_IMPORTE);

        /* +-------------------------------------------------------------------------------------+
          | La segunda parte después de || considera el caso en que se esté iniciando el sistema |
          | y no haya ningún proceso de caja registrado durante todo el ciclo de vida            |
          +--------------------------------------------------------------------------------------+
         */
        if (($cd_movcaja && $cd_concepto == CD_CONCEPTO_EGRESO_CIERRE) || ($cd_movcaja == 0 && $cd_concepto == 0 && $cd_turno == 0)) {
            $cd_usuario = $_SESSION['cd_usuarioSession'];
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro("cd_usuario", $cd_usuario, "=");
            $usuarioManager = new UsuarioRYTManager();
            $oUsuario = $usuarioManager->getUsuario($criterio);
            $xtpl->assign('nu_caja', $oUsuario->getNu_caja());
            $this->parseTurnos($selected, $xtpl);
            $xtpl->parse("main.boton_aceptar");
        } elseif ($cd_movcaja && $cd_concepto == CD_CONCEPTO_INGRESO && $nu_caja_abierta != $nu_caja) {
            $msj_html = "ERROR: No se puede abrir una nueva caja porque ya está abierta la caja Nro. $nu_caja_abierta del usuario " . $oUsuarioCajaAbierta->getDs_nomusuario();
            $xtpl->assign('msj', $msj_html);
            $xtpl->parse("main.msj");
        } else {
            $msj_html = "ERROR: No se puede abrir una nueva caja porque ya hay una caja abierta. Debe <a style='text-decoration:underline;' href='" . WEB_PATH . "doAction?action=cerrar_caja_init'>cerrar la caja</a> para abrir una nueva";
            $xtpl->assign('msj', $msj_html);
            $xtpl->parse("main.msj");
        }
    }

    protected function parseTurnos($selected, XTemplate $xtpl) {

        $manager = new TurnoManager();
        $criterio = new CriterioBusqueda();
        $turnos = $manager->getTurnos($criterio);

        foreach ($turnos as $key => $oTurno) {

            $xtpl->assign('ds_turno', $oTurno->getDs_turno());
            $xtpl->assign('cd_turno', $oTurno->getCd_turno());

            $xtpl->parse('main.turnos_option');
        }
    }

}

