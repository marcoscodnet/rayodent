<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 
 */
class LayoutRYT extends LayoutDesktop {

    protected function parseEstilos($xtpl) {

        parent::parseEstilos($xtpl);

        $xtpl->assign('css', WEB_PATH . "css/rayodent.css");
        $xtpl->parse('main.estilo');

        $xtpl->assign('css', WEB_PATH . "css/desktop/timePicker.css");
        $xtpl->parse('main.estilo');
    }

    protected function parseScripts($xtpl) {
        parent::parseScripts($xtpl);
        $xtpl->assign('js', WEB_PATH . "js/jquery/jquery.timePicker.js");
        $xtpl->parse('main.script');
        $xtpl->assign('js', WEB_PATH . "js/jquery/jquery.blockUI.js");
        $xtpl->parse('main.script');
    }

    protected function getXTemplate($menuGroupActivo='', $menuOptions) {

        //si no tiene menugroupactivo o se indic� que no hay opciones, entonces el template es sin men� lateral.
        if (empty($menuGroupActivo) || (!empty($menuOptions) && ($menuOptions == 'false') ))
            return new XTemplate(RYT_LAYOUT_DESKTOP_TEMPLATE_DEFAULT);
        else
            return new XTemplate(RYT_LAYOUT_DESKTOP_TEMPLATE_MENU);
    }

}

