<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011
 */
class PracticaordenpracticaFactory extends GenericFactory {

    public function build($next) {
        $this->setClassName('Practicaordenpractica');
        $oPracticaordenpractica = parent::build($next);

        if (array_key_exists('cd_ordenpractica', $next)) {
            $ordenpracticaFactory = new OrdenpracticaFactory();
            $oPracticaordenpractica->setOrdenpractica($ordenpracticaFactory->build($next));
        }

        if (array_key_exists('cd_practicaobrasocial', $next)) {
            $practicaObrasocialFactory = new PracticaobrasocialFactory();
            $oPracticaordenpractica->setPracticaobrasocial($practicaObrasocialFactory->build($next));
        }

        if (array_key_exists('cd_informe', $next)) {
            $informeFactory = new InformeFactory();
            $oPracticaordenpractica->setInforme($informeFactory->build($next));
        }

        if (array_key_exists('cd_movcajaconcepto', $next)) {
            $movcajaconceptoFactory = new MovcajaconceptoFactory();
            $oPracticaordenpractica->setMovcajaconcepto($movcajaconceptoFactory->build($next));
        }

        return $oPracticaordenpractica;
    }

}
?>