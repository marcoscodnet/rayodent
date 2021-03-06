<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 12-12-2011
 */
class PacienteobrasocialFactory extends GenericFactory {

    public function build($next) {
        $this->setClassName('Pacienteobrasocial');
        $oPacienteobrasocial = parent::build($next);

        //TODO foreign keys
        if (array_key_exists('ds_obrasocial', $next)) {
            $obrasocialFactory = new ObrasocialFactory();
            $oPacienteobrasocial->setObrasocial($obrasocialFactory->build($next));
        }

        return $oPacienteobrasocial;
    }

}
?>
