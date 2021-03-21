<?php

/**
 * Acción para visualizar un practicaobrasocial.
 *  
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class VerPracticaobrasocialAction extends OutputAction {

    /**
     * consulta un practicaobrasocial.
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        if (isset($_GET ['id'])) {
            $cd_practicaobrasocial = FormatUtils::getParam('id');


            try {
                $id = FormatUtils::getParam('id');

                $criterio = new CriterioBusqueda();
                $criterio->addFiltro('cd_practicaobrasocial', $id, '=');

                $manager = new PracticaobrasocialManager();
                $oPracticaobrasocial = $manager->getPracticaobrasocial($criterio);
            } catch (GenericException $ex) {
                $oPracticaobrasocial = new Practicaobrasocial();
                //TODO ver si se muestra un mensaje de error.
            }

            //se muestra el practicaobrasocial.
            $this->parseEntidad($xtpl, $oPracticaobrasocial);
        }

        $xtpl->assign('titulo', 'Detalle de Nomenclador');
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function getTitulo() {
        return "Ver Nomenclador";
    }

    public function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_VER_PRACTICAOBRASOCIAL);
    }

    public function parseEntidad($xtpl, $oPracticaobrasocial) {
        $xtpl->assign('cd_practicaobrasocial', stripslashes($oPracticaobrasocial->getCd_practicaobrasocial()));
        $xtpl->assign('cd_practicaobrasocial_label', RYT_PRACTICAOBRASOCIAL_CD_PRACTICAOBRASOCIAL);

        $xtpl->assign('cd_practica', stripslashes($oPracticaobrasocial->getPractica()->getDs_practica()));
        $xtpl->assign('cd_practica_label', RYT_PRACTICAOBRASOCIAL_CD_PRACTICA);

        $xtpl->assign('cd_obrasocial', stripslashes($oPracticaobrasocial->getObrasocial()->getDs_obrasocial()));
        $xtpl->assign('cd_obrasocial_label', RYT_PRACTICAOBRASOCIAL_CD_OBRASOCIAL);

        $xtpl->assign('nu_practicaos', stripslashes($oPracticaobrasocial->getNu_practicaos()));
        $xtpl->assign('nu_practicaos_label', RYT_PRACTICAOBRASOCIAL_NU_PRACTICAOS);

        if ($oPracticaobrasocial->getNu_limiterepeticiones() == "" || $oPracticaobrasocial->getNu_limiterepeticiones() == null) {
            $nu_limiterepeticiones = "(Sin límites)";
        } else {
            $nu_limiterepeticiones = $oPracticaobrasocial->getNu_limiterepeticiones();
        }
        $xtpl->assign('nu_limiterepeticiones', stripslashes($nu_limiterepeticiones));
        $xtpl->assign('nu_limiterepeticiones_label', RYT_PRACTICAOBRASOCIAL_NU_LIMITEREPETICIONES);

        $xtpl->assign('nu_importe', "$ " . stripslashes($oPracticaobrasocial->getNu_importe()));
        $xtpl->assign('nu_importe_label', RYT_PRACTICAOBRASOCIAL_NU_IMPORTE);

        $xtpl->assign('dt_vigencia', stripslashes(FuncionesComunes::fechaMysqlaPHP($oPracticaobrasocial->getDt_vigencia())));
        $xtpl->assign('dt_vigencia_label', RYT_PRACTICAOBRASOCIAL_DT_VIGENCIA);
    }

}
