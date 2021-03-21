<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 24-11-2011 
 */ 
class ObrasocialTableModel extends ListarTableModel{

	private $columnNames = array();

	private $columnWidths = array();
	
	public function ObrasocialTableModel(ItemCollection $items){
		$this->items = $items;
		$this->initColumns();
	}
	
	private function initColumns(){
		
		$this->columnNames[] = RYT_OBRASOCIAL_CD_OBRASOCIAL;
		$this->columnWidths[] = 80;
		
		$this->columnNames[] = RYT_OBRASOCIAL_DS_OBRASOCIAL;
		$this->columnWidths[] = 80;
		
		$this->columnNames[] = RYT_OBRASOCIAL_BL_ACTIVA;
		$this->columnWidths[] = 20;
		
	}
	
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Obrasociales";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount(){
		return count($this->columnNames);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getColumnName($columnIndex)
	 */
	function getColumnName($columnIndex){
		return $this->columnNames[$columnIndex];
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getColumnWidth($columnIndex)
	 */
	function getColumnWidth($columnIndex){
		return $this->columnWidths[$columnIndex];
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getRowCount()
	 */
	function getRowCount(){
		$this->items->size();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getValueAt($rowIndex, $columnIndex)
	 */
	function getValueAt($rowIndex, $columnIndex){
		$oObject = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oObject, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oObrasocial = $anObject;
		$value=0;
		switch ($columnIndex) {
			
			case 0: $value= $oObrasocial->getCd_obrasocial(); break;
			
			case 1: $value= $oObrasocial->getDs_obrasocial(); break;
			
			case 2: $value= ($oObrasocial->getBl_activa())?RYT_YES:RYT_NO; break;
			
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_obrasocial', 'cd_obrasocial');
	 	
	 	$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_obrasocial', 'ds_obrasocial');
	 	
	 	$encabezados[]= $this->buildTh($this->getColumnName(2), 'bl_activa', 'bl_activa');
	 	
	 	return $encabezados;	
	}
	
}
?>
