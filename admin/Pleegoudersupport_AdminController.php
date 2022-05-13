<?php
class Pleegoudersupport_AdminController {
    /**
     * This function will prepare all Admin functionality for the plugin
     */
    static function prepare()
    {
        // Check that we are in the admin area
        if (is_admin()) :
        // Add the sidebar Menu structure
        add_action('admin_menu', array('Pleegoudersupport_AdminController', 'addMenus'));
        endif;
    }

    /**
     * Add the Menu structure to the Admin sidebar
     */
    static function addMenus()
    {
        add_menu_page(
            __('Pleegoudersupport Zeeland', 'pleegoudersupport'), // Menu name
            __('Pleegoudersupport Zeeland', 'pleegoudersupport'), //Menu name
            '', //capabillity which is required to show menu.
            'pleegoudersupport-admin', // menu slug
            array('Pleegoudersupport_AdminController', 'adminMenuPage'), //array(name of controller, static function)
            'dashicons-chart-bar' //dashicon
        );
        add_submenu_page(
            'pleegoudersupport-admin', //name of main menu slug
            __('Agendapunt aanmaken', 'pleegoudersupport'), // Menu name
            __('Agendapunt aanmaken', 'pleegoudersupport'), //Menu name
            'manage_options', //capability which is required to show menu
            'admin_aanmelden', //menu slug
            array('Pleegoudersupport_AdminController', 'adminSubMenuAanmelden') //array(name of controller, static function)
        );
        add_submenu_page(
            'pleegoudersupport-admin', //name of main menu slug
            __('Agenda Overzicht', 'pleegoudersupport'), // Menu name
            __('Agenda Overzicht', 'pleegoudersupport'), //Menu name
            'manage_options', //capability which is required to show menu
            'admin_overzicht', //menu slug
            array('Pleegoudersupport_AdminController', 'adminSubMenuOverzicht') //array(name of controller, static function)
        );
        add_submenu_page(
            'pleegoudersupport-admin', //name of main menu slug
            __('Nieuwsbrief', 'pleegoudersupport'), // Menu name
            __('Nieuwsbrief', 'pleegoudersupport'), //Menu name
            'manage_options', //capability which is required to show menu
            'admin_nieuwsbrief', //menu slug
            array('Pleegoudersupport_AdminController', 'adminSubMenuNieuwsbrief') //array(name of controller, static function)
        );

        add_submenu_page(
            'pleegoudersupport-admin', //name of main menu slug
            __('Emailgroep Overzicht', 'pleegoudersupport'), // Menu name
            __('Emailgroep Overzicht', 'pleegoudersupport'), //Menu name
            'manage_options', //capability which is required to show menu
            'admin_emailgroep_overzicht', //menu slug
            array('Pleegoudersupport_AdminController', 'adminSubMenuEmailgroepOverzicht') //array(name of controller, static function)
        );

        add_submenu_page(
            'pleegoudersupport-admin', //name of main menu slug
            __('Email Overzicht', 'pleegoudersupport'), // Menu name
            __('Email Overzicht', 'pleegoudersupport'), //Menu name
            'manage_options', //capability which is required to show menu
            'admin_email_overzicht', //menu slug
            array('Pleegoudersupport_AdminController', 'adminSubMenuEmailOverzicht') //array(name of controller, static function)
        );
    }

    static function adminSubMenuAanmelden()
    {
// Include view for sub-menu page
        include PLEEGOUDERSUPPORT_PLUGIN_ADMIN_VIEWS_DIR . '/admin_aanmelden.php';
    }

    static function adminSubMenuOverzicht()
    {
// Include view for sub-menu page
        include PLEEGOUDERSUPPORT_PLUGIN_ADMIN_VIEWS_DIR . '/admin_overzicht.php';
    }

    static function adminSubMenuNieuwsbrief()
    {
// Include view for sub-menu page
        include PLEEGOUDERSUPPORT_PLUGIN_ADMIN_VIEWS_DIR . '/admin_nieuwsbrief.php';
    }

    static function adminSubMenuEmailgroepOverzicht()
    {
// Include view for sub-menu page
        include PLEEGOUDERSUPPORT_PLUGIN_ADMIN_VIEWS_DIR . '/admin_emailgroep_overzicht.php';
    }

    static function adminSubMenuEmailOverzicht()
    {
// Include view for sub-menu page
        include PLEEGOUDERSUPPORT_PLUGIN_ADMIN_VIEWS_DIR . '/admin_email_overzicht.php';
    }
    
}
