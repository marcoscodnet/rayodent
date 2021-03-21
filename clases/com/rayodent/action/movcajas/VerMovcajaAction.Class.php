<?php

/**
 * Acci�n para visualizar un movcaja.
 *  
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class VerMovcajaAction extends OutputAction {

    /**
     * consulta un movcaja.
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        if (isset($_GET ['id'])) {
            $cd_movcaja = FormatUtils::getParam('id');


            try {
                $id = FormatUtils::getParam('id');

                $criterio = new CriterioBusqueda();
                $criterio->addFiltro('MC.cd_movcaja', $id, '=');

                $manager = new MovcajaManager();
                $oMovcaja = $manager->getMovcaja($criterio);
            } catch (GenericException $ex) {
                $oMovcaja = new Movcaja();
            }

            //se muestra el movcaja.
            $this->parseEntidad($xtpl, $oMovcaja);
        }

        $xtpl->assign('titulo', 'Detalle de Movimiento de Caja');
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function getTitulo() {
        return "Ver Movimiento de caja";
    }

    public function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_VER_MOVCAJA);
    }

    public function parseEntidad($xtpl, $oMovcaja) {
        $xtpl->assign('cd_movcaja', stripslashes($oMovcaja->getCd_movcaja()));
        $xtpl->assign('cd_movcaja_label', RYT_MOVCAJA_CD_MOVCAJA);

        $xtpl->assign('dt_movcaja', stripslashes(FuncionesComunes::fechaHoraMysqlaPHP($oMovcaja->getDt_movcaja())));
        $xtpl->assign('dt_movcaja_label', RYT_MOVCAJA_DT_MOVCAJA);

        $xtpl->assign('ds_observacion', stripslashes($oMovcaja->getDs_observacion()));
        $xtpl->assign('ds_observacion_label', RYT_MOVCAJA_DS_OBSERVACION);

        $xtpl->assign('nu_caja', stripslashes($oMovcaja->getNu_caja()));
        $xtpl->assign('nu_caja_label', RYT_MOVCAJA_NU_CAJA);

        $xtpl->assign('cd_usuario', stripslashes($oMovcaja->getUsuario()->getDs_nomusuario()));
        $xtpl->assign('cd_usuario_label', RYT_MOVCAJA_CD_USUARIO);

        $xtpl->assign('cd_turno', stripslashes($oMovcaja->getTurno()->getDs_turno()));
        $xtpl->assign('cd_turno_label', RYT_MOVCAJA_CD_TURNO);

        $this->parseMovcajaconcepto($xtpl, $oMovcaja);
        $href = 'doAction?action=pdf_etiqueta_movcaja&id=' . $oMovcaja->getCd_movcaja();
        $onclick = "javascript: window.location.href='" . $href . "'";
        $xtpl->assign('onclick_imprimir', $onclick);
    }

    public function parseMovcajaconcepto($xtpl, $oMovcaja) {
        $cd_movcaja = $oMovcaja->getCd_movcaja();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("MCC.cd_movcaja", $cd_movcaja, "=");
        $movcajaconceptosManager = new MovcajaconceptoManager();
        $listado_cajaconceptos = $movcajaconceptosManager->getMovcajaconceptos($criterio);
        $total = 0;
        foreach ($listado_cajaconceptos as $key => $oMovCajaConceptos) {
            $xtpl->assign('ds_tipoconcepto', $oMovCajaConceptos->getConcepto()->getTipoconcepto()->getDs_tipoconcepto());
            $cd_tipooperacion = $oMovCajaConceptos->getConcepto()->getCd_tipooperacion();
            $coeficiente = $this->getCoeficiente($cd_tipooperacion);
            //Si es particular, el valor de la pr�ctica es 0
           
            if ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() != CD_TIPO_CONCEPTO_PRACTICA || ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_PRACTICA && $oMovCajaConceptos->getPracticaordenpractica()->getPracticaobrasocial()->getCd_obrasocial() == CD_OBRASOCIAL_PARTICULAR)) {
                $total += $oMovCajaConceptos->getNu_importe() * $coeficiente;
            }
            $xtpl->assign('nu_importe', "$" . ($oMovCajaConceptos->getNu_importe() * $coeficiente));
            $ds_posnet = ($oMovCajaConceptos->getBl_tarjeta()==1)?'SI':'NO';
            $xtpl->assign('ds_posnet', $ds_posnet);
            $xtpl->assign('ds_concepto', $oMovCajaConceptos->getConcepto()->getDs_concepto());

            $criterio = new CriterioBusqueda();

            $criterio->addFiltro("MCC.cd_movcajaconcepto", $oMovCajaConceptos->getCd_movcajaconcepto(), "=");
            $practicaordenpracticaManager = new PracticaordenpracticaManager();
            $oPracticaOrdenpractica = $practicaordenpracticaManager->getPracticaordenpractica($criterio);
            if (!empty($oPracticaOrdenpractica)) {
                $xtpl->assign('ds_obrasocial', $oPracticaOrdenpractica->getPracticaobrasocial()->getObrasocial()->getDs_obrasocial());
                $xtpl->assign('ds_practica', $oPracticaOrdenpractica->getPracticaObrasocial()->getPractica()->getDs_practica());
                $xtpl->assign('ds_paciente', $oPracticaOrdenpractica->getOrdenpractica()->getPaciente()->getDs_apynom());
                $xtpl->assign('cd_paciente', $oPracticaOrdenpractica->getOrdenpractica()->getPaciente()->getCd_paciente());
                $xtpl->assign('ds_profesional', $oPracticaOrdenpractica->getOrdenpractica()->getProfesional()->getDs_nombre());
                $xtpl->assign('cd_profesional', $oPracticaOrdenpractica->getOrdenpractica()->getProfesional()->getCd_profesional());
                if ($oPracticaOrdenpractica->getCd_aporteos() == 1) {
                    $xtpl->assign('cd_aporteos', "Obligatorio");
                } else {
                    $xtpl->assign('cd_aporteos', "Voluntario");
                }
                $xtpl->assign('nu_cantplacas', $oPracticaOrdenpractica->getNu_cantplacas());
            } else {
                $xtpl->assign('ds_obrasocial', "&nbsp;");
                $xtpl->assign('ds_practica', "&nbsp;");
                $xtpl->assign('ds_paciente', "&nbsp;");
                $xtpl->assign('ds_profesional', "&nbsp;");
                $xtpl->assign('cd_aporteos', "&nbsp;");
                $xtpl->assign('nu_cantplacas', "&nbsp;");
            }
            $xtpl->parse('main.movscajas_conceptos');
            $xtpl->assign('nu_total', "$" . $total);
        }
    }

    protected function getCoeficiente($cd_tipooperacion) {
        $oTipooperacionmanager = new TipooperacionManager();
        return $oTipooperacionmanager->getCoeficiente($cd_tipooperacion);
    }

}
