<?php

/**
 * Acción para inicializar el contexto para dar de alta
 * un contacto.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class AltaContactoInitAction extends EditarContactoInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return "Alta Contacto";
    }

    protected function getEntidad() {
       
        return parent::getEntidad();
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
     */
    protected function getAccionSubmit() {
        return "alta_contacto";
    }

   

}
