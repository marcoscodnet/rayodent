<?php

/**
 * Acción listar obrasociales.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ActualizarObrassocialesSeleccionadasAction extends Action {

    public function execute() {
        $xtpl = $this->getXTemplate();
        $this->parseObrassociales($xtpl);
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        echo FormatUtils::quitarEnters($text);
    }

    protected function parseObrassociales(XTemplate $xtpl) {
        $criterio = new CriterioBusqueda();
        foreach ($_SESSION['pacientesobrasociales_session'] as $key => $cd_obrasocial) {
            $criterio->addFiltro("cd_obrasocial", $cd_obrasocial, "=", new FormatValor(), "OR");
        }
        $manager = new ObrasocialManager();
        $obrassociales = $manager->getObrasociales($criterio);


        foreach ($obrassociales as $key => $oObrasocial) {
            $xtpl->assign('ds_obrasocial', utf8_encode($oObrasocial->getDs_obrasocial()));
            $xtpl->parse('main.pacientesobrassociales');
        }
    }

    protected function getLayout() {
        return new LayoutSimple();
    }

    protected function getXTemplate() {
        return new XTemplate(RYT_LISTADO_AJAX_PACIENTESOBRASSOCIALES);
    }

}
