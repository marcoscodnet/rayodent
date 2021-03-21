<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011 
 */
class GastosManager extends MovcajaManager {

    public function getListadoMovcajas(CriterioBusqueda $criterio) {
        $listado_movcajas = MovcajaDAO::getMovcajasGastos($criterio);
        foreach ($listado_movcajas as $oMovcaja) {
            $cd_movcaja = $oMovcaja->getCd_movcaja();
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro("MCC.cd_movcaja", $cd_movcaja, "=");
            $criterio->addFiltro("C.cd_tipoconcepto", CD_TIPO_CONCEPTO_GASTOS, "=");
            $movcajaconceptosManager = new MovcajaconceptoManager();
            $listado_cajaconceptos = $movcajaconceptosManager->getMovcajaconceptos($criterio);
            $detalle = "<ul>";
            $total = 0;
            foreach ($listado_cajaconceptos as $key => $oMovCajaConceptos) {
                $detalle .= "<li>" . $oMovCajaConceptos->getConcepto()->getDs_concepto() . " (" . $oMovCajaConceptos->getConcepto()->getTipoconcepto()->getDs_tipoconcepto() . ") / ";
                $cd_tipooperacion = $oMovCajaConceptos->getConcepto()->getCd_tipooperacion();
                $coeficiente = $this->getCoeficiente($cd_tipooperacion);
                $valor = $oMovCajaConceptos->getNu_importe() * $coeficiente;
                $detalle .= "$" . $valor . "</li>";
                if ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() != CD_TIPO_CONCEPTO_PRACTICA || ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_PRACTICA && $oMovCajaConceptos->getPracticaordenpractica()->getPracticaobrasocial()->getCd_obrasocial() == CD_OBRASOCIAL_PARTICULAR)) {
                    $total += $valor;
                }
            }
            $detalle .="</ul>";
            $oMovcaja->setDs_detalle($detalle);
            $oMovcaja->setNu_total($total);
        }
        return $listado_movcajas;
    }

    public function getCantMovcajas(CriterioBusqueda $criterio) {
        return MovcajaDAO::getCantMovcajasGastos($criterio);
    }

    //	interface IListar
    public function getEntidades(CriterioBusqueda $criterio) {
        return $this->getListadoMovcajas($criterio);
    }

    public function getCantidadEntidades(CriterioBusqueda $criterio) {
        return $this->getCantMovcajas($criterio);
    }

}
?>