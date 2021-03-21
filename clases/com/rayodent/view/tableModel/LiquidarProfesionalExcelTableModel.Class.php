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
class LiquidarProfesionalExcelTableModel extends LiquidarProfesionalTableModel {

    private $columnNames = array();
    private $columnWidths = array();

    public function LiquidarProfesionalExcelTableModel(ItemCollection $items) {
        $this->items = $items;
        $this->initColumns();
    }

    private function initColumns() {
        $this->columnNames[] = RYT_PRACTICAORDENPRACTICA_DT_CARGA;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PRACTICAORDENPRACTICA_NU_PRACTICA;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_LIQUIDACION_NU_IMPORTE;
        $this->columnWidths[] = 80;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getTitle()
     */
    function getTitle() {
        return "Liquidaci&oacute;n de Profesionales";
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

            case 0: $value = FuncionesComunes::fechaHoraMysqlaPHP($oPracticaordenpractica->getOrdenpractica()->getDt_carga());
                break;
            case 1: $value = $oPracticaordenpractica->getPracticaobrasocial()->getNu_practicaos();
                break;
            case 2: $value = $oPracticaordenpractica->getNu_importealiquidar();
                break;
            default: $value = '';
                break;
        }
        return $value;
    }

    public function getEncabezados() {

        $encabezados[] = $this->buildTh($this->getColumnName(0), 'dt_carga', 'dt_carga');

        $encabezados[] = $this->buildTh($this->getColumnName(1), 'nu_practicaos', 'nu_practicaos');

        $encabezados[] = $this->buildTh($this->getColumnName(2), 'nu_importealiquidar', 'nu_importealiquidar');

        return $encabezados;
    }

}
?>
