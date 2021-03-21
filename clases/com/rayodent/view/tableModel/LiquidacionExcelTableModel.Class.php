<?php

/**
 * El Botón ?Exportar? exporta los datos a un archivo .xls con el formato:
 * nombre y apellido del paciente, cód práctica (el que se le cargó a mano), importe de la práctica

 * preacticaobrasocial, es el código que ingresan a mano ellos para identificarlo a la OS), importe
 */
class LiquidacionExcelTableModel extends MovcajaTableModel {

    private $columnNames = array();
    private $columnWidths = array();

    public function LiquidacionExcelTableModel(ItemCollection $items) {
        $this->items = $items;
        $this->initColumns();
    }

    private function initColumns() {
        $this->columnNames[] = RYT_PRACTICAORDENPRACTICA_CD_PACIENTE;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PRACTICAOBRASOCIAL_NU_PRACTICAOS;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PRACTICAOBRASOCIAL_NU_IMPORTE;
        $this->columnWidths[] = 80;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getTitle()
     */
    function getTitle() {
        return "Movcajas";
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
        $oMovcaja = $anObject;
        $value = 0;
        switch ($columnIndex) {

            case 0: $value = $oMovcaja->getDs_paciente();
                break;
            case 1: $value = $oMovcaja->getDs_detalle();
                break;
            case 2: $value = $oMovcaja->getNu_total();
                break;

            default: $value = '';
                break;
        }
        return $value;
    }

    public function getEncabezados() {
        $encabezados[] = $this->buildTh($this->getColumnName(0), 'cd_paciente', 'cd_paciente');
        $encabezados[] = $this->buildTh($this->getColumnName(1), 'dt_movcaja', 'nu_practica_os');
        $encabezados[] = $this->buildTh($this->getColumnName(2), 'nu_total', 'nu_total');
        return $encabezados;
    }

}
?>
