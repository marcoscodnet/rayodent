<?php

/**
 * Acción listar tipoDocumentos.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ListarTipoDocumentosAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new TipoDocumentoTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altatipoDocumento', 'Agregar Tipo Doc.', 'alta_tipodocumento_init');
        return $opciones;
    }

    protected function getFiltros() {
        
        $filtros = array();
        		
		$filtros[] = $this->buildFiltro('cd_tipodocumento', RYT_TIPODOCUMENTO_CD_TIPODOCUMENTO);
				
		$filtros[] = $this->buildFiltro('ds_tipodocumento', RYT_TIPODOCUMENTO_DS_TIPODOCUMENTO);
		
        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_tipodocumento(), 'tipodocumento', 'tipodocumento', true, true, true);
    }


    protected function getEntidadManager() {
        return new TipoDocumentoManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_tipodocumento';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Tipo de Documentos';
    }

    protected function getUrlAccionListar() {
        return 'listar_tipodocumentos';
    }

    protected function getForwardError() {
        return 'listar_tipodocumentos_error';
    }

    protected function getMenuActivo() {
        return "TipoDocumentos";
    }

    protected function getCartelEliminar($entidad) {
		$xtpl = new XTemplate(RYT_TEMPLATE_BAJA_TIPODOCUMENTO);
        $xtpl->assign('cd_tipodocumento', $entidad->getCd_tipodocumento());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
