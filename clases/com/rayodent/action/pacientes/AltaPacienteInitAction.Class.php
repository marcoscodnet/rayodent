<?php

/**
 * Acción para inicializar el contexto para dar de alta
 * un paciente.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class AltaPacienteInitAction extends EditarPacienteInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return "Alta Paciente";
    }

    protected function getEntidad() {
        unset($_SESSION['pacientesobrasociales_session']);
        return parent::getEntidad();
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
     */
    protected function getAccionSubmit() {
        return "alta_paciente";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
     */
    protected function getMostrarCodigo() {
        return false;
    }

}
