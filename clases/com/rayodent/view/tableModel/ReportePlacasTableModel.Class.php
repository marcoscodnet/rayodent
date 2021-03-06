<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011 
 */
class ReportePlacasTableModel extends ListarTableModel {

    private $columnNames = array();
    private $columnWidths = array();

    public function ReportePlacasTableModel(ItemCollection $items) {
        $this->items = $items;
        $this->initColumns();
    }

    private function initColumns() {
        $this->columnNames[] = RYT_MOVCAJA_DT_MOVCAJA;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PRACTICA_DS_PRACTICA;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PRACTICAORDENPRACTICA_NU_CANTPLACAS;
        $this->columnWidths[] = 80;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getTitle()
     */
    function getTitle() {
        return "Reporte Placas";
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

            case 0: $value = substr(FuncionesComunes::fechaHoraMysqlaPHP($oPracticaordenpractica->getDt_movcaja()), 0, 10);
                break;
            case 1: $value = $oPracticaordenpractica->getDs_practica();
                break;
            case 2: $value = $oPracticaordenpractica->getNu_cantplacas();
                break;
            default: $value = '';
                break;
        }
        return $value;
    }

    public function getEncabezados() {
        $encabezados[] = $this->buildTh($this->getColumnName(0), 'dt_movcaja', 'dt_movcaja');
        $encabezados[] = $this->buildTh($this->getColumnName(1), 'ds_practica', 'ds_practica');
        $encabezados[] = $this->buildTh($this->getColumnName(2), 'nu_cantplacas', 'nu_cantplacas');
        return $encabezados;
    }

}
?>
