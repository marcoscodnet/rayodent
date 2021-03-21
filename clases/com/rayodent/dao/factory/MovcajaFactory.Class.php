<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011
 */
class MovcajaFactory extends GenericFactory {

    private $aliasMovcaja;

    public function MovcajaFactory($alias="") {
        $this->aliasMovcaja = $alias;
    }

    public function build($next) {
        $oMovcaja = new Movcaja();
        $oMovcaja->setCd_movcaja($next[$this->aliasMovcaja . 'cd_movcaja']);
        $oMovcaja->setDt_movcaja($next[$this->aliasMovcaja . 'dt_movcaja']);
        $oMovcaja->setDs_observacion($next[$this->aliasMovcaja . 'ds_observacion']);
        $oMovcaja->setNu_caja($next[$this->aliasMovcaja . 'nu_caja']);
        $oMovcaja->setCd_usuario($next[$this->aliasMovcaja . 'cd_usuario']);
        $oMovcaja->setBl_anulacion($next[$this->aliasMovcaja . 'bl_anulacion']);
        $oMovcaja->setCd_turno($next[$this->aliasMovcaja . 'cd_turno']);
		$oMovcaja->setNu_etiquetasimple($next[$this->aliasMovcaja . 'nu_etiquetasimple']);
		$oMovcaja->setNu_etiquetadoble($next[$this->aliasMovcaja . 'nu_etiquetadoble']);
        //TODO foreign keys
        if (array_key_exists('ds_nomusuario', $next)) {
            $usuarioFactory = new UsuarioRYTFactory();
            $oMovcaja->setUsuario($usuarioFactory->build($next));
        }

        if (array_key_exists('ds_turno', $next)) {
            $turnoFactory = new TurnoFactory();
            $oMovcaja->setTurno($turnoFactory->build($next));
        }

        /*if (array_key_exists('cd_ordenpractica', $next) && $next['cd_ordenpractica'] != NULL) {
            $ordenpracticaFactory = new OrdenpracticaFactory();
            //$oMovcaja->setTurno($turnoFactory->build($next));
        }*/

        return $oMovcaja;
    }

}
?>
