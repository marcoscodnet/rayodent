<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 12-12-2011 
 */
class PacienteTableModel extends ListarTableModel {

    private $columnNames = array();
    private $columnWidths = array();

    public function PacienteTableModel(ItemCollection $items) {
        $this->items = $items;
        $this->initColumns();
    }

    private function initColumns() {

        $this->columnNames[] = RYT_PACIENTE_CD_PACIENTE;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PACIENTE_DS_APYNOM;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PACIENTE_CD_TIPODOC;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PACIENTE_NU_DOC;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PACIENTE_DS_DIRECCION;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_PACIENTE_DS_EMAIL;
        $this->columnWidths[] = 80;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getTitle()
     */
    function getTitle() {
        return "Pacientes";
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
        $oPaciente = $anObject;
        $value = 0;
        switch ($columnIndex) {

            case 0: $value = $oPaciente->getCd_paciente();
                break;

            case 1: $value = $oPaciente->getDs_apynom();
                break;

            case 2: $value = $oPaciente->getTipodoc()->getDs_tipodocumento();
                break;

            case 3: $value = $oPaciente->getNu_doc();
                break;

            case 4: $value = $oPaciente->getDs_direccion();
                break;

            case 5: $value = $oPaciente->getDs_email();
                break;

            default: $value = '';
                break;
        }
        return $value;
    }

    public function getEncabezados() {

        $encabezados[] = $this->buildTh($this->getColumnName(0), 'cd_paciente', 'cd_paciente');

        $encabezados[] = $this->buildTh($this->getColumnName(1), 'ds_apynom', 'ds_apynom');

        $encabezados[] = $this->buildTh($this->getColumnName(2), 'cd_tipodoc', 'cd_tipodoc');

        $encabezados[] = $this->buildTh($this->getColumnName(3), 'nu_doc', 'nu_doc');

        $encabezados[] = $this->buildTh($this->getColumnName(4), 'ds_direccion', 'ds_direccion');

        $encabezados[] = $this->buildTh($this->getColumnName(5), 'ds_email', 'ds_email');

        return $encabezados;
    }

}
?>
