<?php

/**
 * Acción para inicializar el contexto para modificar
 * un concepto.
 *  
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ModificarConceptoInitAction extends EditarConceptoInitAction {

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_EDITAR_DESCRIPCION);
    }

    protected function getEntidad() {
        $oConcepto = null;

        if (isset($_GET ['id'])) {
            //recuperamos dado su identifidor.
            $id = FormatUtils::getParam('id');

            $criterio = new CriterioBusqueda();
            $criterio->addFiltro('cd_concepto', $id, '=');

            $manager = new ConceptoManager();
            $oConcepto = $manager->getConcepto($criterio);
        } else {

            $oConcepto = parent::getEntidad();
        }
        return $oConcepto;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return "Modificar Concepto";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
     */
    protected function getAccionSubmit() {
        return "modificar_concepto";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
     */
    protected function getMostrarCodigo() {
        return true;
    }

}
