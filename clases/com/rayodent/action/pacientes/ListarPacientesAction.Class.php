<?php

/**
 * Acci�n listar pacientes.
 *
 * @author modelBuilder
 * @since 12-12-2011
 *
 */
class ListarPacientesAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new PacienteTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altapaciente', 'Agregar Paciente', 'alta_paciente_init');
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();
        $filtros[] = $this->buildFiltro('ds_apynom', RYT_PACIENTE_DS_APYNOM);
        $filtros[] = $this->buildFiltro('nu_doc', RYT_PACIENTE_NU_DOC);
        $filtros[] = $this->buildFiltro('ds_direccion', RYT_PACIENTE_DS_DIRECCION);
        $filtros[] = $this->buildFiltro('ds_email', RYT_PACIENTE_DS_EMAIL);
        $filtros[] = $this->buildFiltro('ds_medio', RYT_PACIENTE_CD_MEDIO);

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_paciente(), 'paciente', 'paciente', true, true, true);
    }

    protected function getEntidadManager() {
        return new PacienteManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_paciente';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Pacientes';
    }

    protected function getUrlAccionListar() {
        return 'listar_pacientes';
    }

    protected function getForwardError() {
        return 'listar_pacientes_error';
    }

    protected function getMenuActivo() {
        return "Pacientes";
    }

    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_BAJA_PACIENTE);
        $xtpl->assign('cd_paciente', $entidad->getCd_paciente());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

    protected function getUrlAccionExportarExcel() {
        return 'excel_pacientes';
    }


}
