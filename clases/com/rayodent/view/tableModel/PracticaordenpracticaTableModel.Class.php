<?php

/**
 * Nº de orden (código de orden práctica)
 * Descripción de Obra social
 * Descripción de práctica
 * Nº práctica (nu_practicaos)
 * Fecha/hora de carga
 * Paciente (Apy nom)
 * Acciones
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011 
 */
class PracticaordenpracticaTableModel extends ListarTableModel {

    private $columnNames = array();
    private $columnWidths = array();

    public function PracticaordenpracticaTableModel(ItemCollection $items) {
        $this->items = $items;
        $this->initColumns();
    }

    private function initColumns() {

        $this->columnNames[] = RYT_PRACTICAORDENPRACTICA_CD_ORDENPRACTICA;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PRACTICAORDENPRACTICA_CD_OBRASOCIAL;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PRACTICAORDENPRACTICA_CD_PRACTICA;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PRACTICAORDENPRACTICA_NU_PRACTICA;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PRACTICAORDENPRACTICA_DT_CARGA;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PRACTICAORDENPRACTICA_CD_PACIENTE;
        $this->columnWidths[] = 80;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getTitle()
     */
    function getTitle() {
        return "Administraci&oacute;n de Pr&aacute;cticas";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getColumnCount()
     */
    function getColumnCount() {
        return count($this->columnNames);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getColumnName($columnIndex)
     */
    function getColumnName($columnIndex) {
        return $this->columnNames[$columnIndex];
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getColumnWidth($columnIndex)
     */
    function getColumnWidth($columnIndex) {
        return $this->columnWidths[$columnIndex];
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getRowCount()
     */
    function getRowCount() {
        $this->items->size();
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getValueAt($rowIndex, $columnIndex)
     */
    function getValueAt($rowIndex, $columnIndex) {
        $oObject = $this->items->getObjectByIndex($rowIndex);
        return $this->getValue($oObject, $columnIndex);
    }

    public function getValue($anObject, $columnIndex) {

        $oPracticaordenpractica = $anObject;
        $value = 0;
        switch ($columnIndex) {

            case 0: $value = $oPracticaordenpractica->getCd_ordenpractica();
                break;

            case 1: $value = $oPracticaordenpractica->getPracticaobrasocial()->getObrasocial()->getDs_obrasocial();
                break;

            case 2: $value = $oPracticaordenpractica->getPracticaobrasocial()->getPractica()->getDs_practica();
                break;

            case 3: $value = $oPracticaordenpractica->getPracticaobrasocial()->getNu_practicaos();
                break;

            case 4: $value = FuncionesComunes::fechaHoraMysqlaPHP($oPracticaordenpractica->getOrdenpractica()->getDt_carga());
                break;

            case 5: $value = $oPracticaordenpractica->getOrdenpractica()->getPaciente()->getDs_apynom();
                break;

            default: $value = '';
                break;
        }
        return $value;
    }

    public function getEncabezados() {

        $encabezados[] = $this->buildTh($this->getColumnName(0), 'OP.cd_ordenpractica', 'OP.cd_ordenpractica');

        $encabezados[] = $this->buildTh($this->getColumnName(1), 'ds_obrasocial', 'ds_obrasocial');

        $encabezados[] = $this->buildTh($this->getColumnName(2), 'ds_practica', 'ds_practica');

        $encabezados[] = $this->buildTh($this->getColumnName(3), 'nu_practicaos', 'nu_practicaos');

        $encabezados[] = $this->buildTh($this->getColumnName(4), 'dt_carga', 'dt_carga');

        $encabezados[] = $this->buildTh($this->getColumnName(5), 'ds_apynom', 'ds_apynom');

        return $encabezados;
    }

}
?>
