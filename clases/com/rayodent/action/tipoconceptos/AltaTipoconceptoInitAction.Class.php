<?php

/**
 * Acción para inicializar el contexto para dar de alta
 * un tipoconcepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class AltaTipoconceptoInitAction extends EditarTipoconceptoInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return "Alta Tipo de concepto";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
     */
    protected function getAccionSubmit() {
        return "alta_tipoconcepto";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
     */
    protected function getMostrarCodigo() {
        return false;
    }

}
