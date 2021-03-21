<?php
/**
 * Formatea un valor a usar en el criterio de bÚsqueda
 * 
 * @author bernardo
 * @since 06-05-10
 *
 */
class FormatValorLikeContacto extends FormatValor{
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/dao/criterio/FormatValor#format($value)
	 */
	public function format($value){
		return "'" . $value . "%'";
	}
}
?>