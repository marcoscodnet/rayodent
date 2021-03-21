<?php

/**
 * Acci�n para visualizar un cuerpo de  email.
 *  
 * @author Marcos
 * @since 16-10-2018
 * 
 */
class VerCuerpoAction extends OutputAction {

	
	protected function getLayout(){
		$oLayout = new BasicLayoutRYT();
		return $oLayout;
	}
	
    /**
     * consulta un email.
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        if (isset($_GET ['id'])) {
            $cd_email = FormatUtils::getParam('id');


            try {
                $id = FormatUtils::getParam('id');

                $criterio = new CriterioBusqueda();
                $criterio->addFiltro('cd_email', $id, '=');

                $manager = new EmailManager();
                $oEmail = $manager->getEmail($criterio);
            } catch (GenericException $ex) {
                $oEmail = new Email();
                //TODO ver si se muestra un mensaje de error.
            }

            //se muestra el email.
            $this->parseEntidad($xtpl, $oEmail);
        }

        $xtpl->assign('titulo', 'Cuerpo de E-mail');
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function getTitulo() {
        return "Ver Cuerpo de E-mail";
    }

    public function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_VER_CUERPO);
    }

    public function parseEntidad($xtpl, $oEmail) {

       

        $xtpl->assign('ds_cuerpo', nl2br(utf8_decode($oEmail->getDs_cuerpo())));
        
       

        
    }

    

}
