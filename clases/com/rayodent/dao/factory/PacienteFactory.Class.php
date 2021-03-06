<?php

/**
 * Autogenerated class
 *
 *  @author modelBuilder
 *  @since 12-12-2011
 */
class PacienteFactory extends GenericFactory {

    public function build($next) {
        $this->setClassName('Paciente');
        $oPaciente = parent::build($next);

        //TODO foreign keys
        if (array_key_exists('ds_tipodocumento', $next)) {
            $tipodocumentoFactory = new TipoDocumentoFactory();
            $oPaciente->setTipodoc($tipodocumentoFactory->build($next));
        }

        if (array_key_exists('ds_medio', $next)) {
            $medioFactory = new MedioFactory();

            $oPaciente->setMedio($medioFactory->build($next));

        }


        return $oPaciente;
    }

}
?>
