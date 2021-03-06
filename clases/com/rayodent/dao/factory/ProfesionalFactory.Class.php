<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 28-10-2011
 */
class ProfesionalFactory extends GenericFactory {

    public function build($next) {
        $this->setClassName('Profesional');
        $oProfesional = parent::build($next);

        if (array_key_exists('ds_tipodocumento', $next)) {
            $tipodocumentoFactory = new TipoDocumentoFactory();
            $oProfesional->setTipoDocumento($tipodocumentoFactory->build($next));
        }

        return $oProfesional;
    }

}
?>
