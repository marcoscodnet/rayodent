<?php

/**
 * Acción para modificar un practicaordenpractica.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ModificarPracticaordenpracticaAction extends EditarPracticaordenpracticaAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $oInformeManager = new InformeManager();
        if ($oEntidad->getInforme()->getCd_informe() == "") {
            $oInformeManager->agregarInforme($oEntidad->getInforme());
            $oEntidad->setCd_informe($oEntidad->getInforme()->getCd_informe());
        } else {
            $oInformeManager->modificarInforme($oEntidad->getInforme());
        }
        $manager = new PracticaordenpracticaManager();
        $manager->modificarPracticaordenpractica($oEntidad);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'modificar_practicaordenpractica_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'modificar_practicaordenpractica_error';
    }

    public function getIdEntidad() {
        return FormatUtils::getParamPOST('id');
    }

    protected function getActionForwardFailure() {
        return 'modificar_practicaordenpractica_init';
    }

}
