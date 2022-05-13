<?php
/**
 * Plugin Name: Pleegoudersupport Zeeland
 * Plugin URI: https://www.pleegoudersupport.nl/
 * Description: Plugin exclusief voor Pleegoudersupport Zeeland.
 * Author: Aaron Wakefield
 * Author URI: https://stichtingivs.nl
 * Version: 0.0.1
 * Text Domain: PleegoudersupportZeeland
 * Domain Path: pleegoudersupportzeeland
 */
// Define the plugin name:
define('PLEEGOUDERSUPPORT_PLUGIN', __FILE__);

// Include the general definition file:
require_once plugin_dir_path(__FILE__) . 'includes/defs.php';
    
/* Register the hooks */
register_activation_hook(__FILE__, array('pleegoudersupport', 'on_activation'));
register_deactivation_hook(__FILE__, array('pleegoudersupport', 'on_deactivation'));

class pleegoudersupport
{

    public function __construct()
    {
        // Fire a hook before the class is setup.
        do_action('pleegoudersupport_pre_init');
        // Load the plugin.
        add_action('init', array($this, 'init'), 1);
    }

    public static function on_activation()
    {
        if (!current_user_can('activate_plugins'))
            return;
        $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
        // check_admin_referer("activate-plugin_{$plugin}");
        // Create the DB
        pleegoudersupport::createDb();
    }

    public static function on_deactivation()
    {
        if (!current_user_can('activate_plugins'))
            return;
        $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
        // check_admin_referer("deactivate-plugin_{$plugin}");

        pleegoudersupport::delete_plugin_database_tables();
    }

    public static function on_install()
    {
        if (!current_user_can('activate_plugins'))
            return;
        $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
        // check_admin_referer("deactivate-plugin_{$plugin}");
    }

    public function init()
    {
        // Run hook once Plugin has been initialized.
        do_action('pleegoudersupport_init');
        // Load admin only components.
        if (is_admin()) {
            // Load all admin specific includes
            $this->requireAdmin();
            // Setup admin page
            $this->createAdmin();
        }
    }

    /**
     * Loads all admin related files into scope.
     */
    public function requireAdmin()
    {
        // Admin controller file
        require_once PLEEGOUDERSUPPORT_PLUGIN_ADMIN_DIR .
            '/pleegoudersupport_AdminController.php';
    }

    /**
     * Admin controller functionality
     */
    public function createAdmin()
    {
        pleegoudersupport_AdminController::prepare();
    }

    /**
     * Create database table
     */
    public static function createDb()
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        //Calling $wpdb;
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        //Names of the tables that will be added to the db
        $psagenda = $wpdb->prefix . "ps_agenda";
        $psnieuwsletter = $wpdb->prefix . "ps_nieuwsletter";

        //Create the pleegoudersupport agenda table
        $sql = "CREATE TABLE IF NOT EXISTS $psagenda (
            id INT NOT NULL AUTO_INCREMENT,
            titel VARCHAR(75) NOT NULL,
            datum VARCHAR(11) NOT NULL,
            tijd VARCHAR(75) NOT NULL,
            beschrijving VARCHAR(1000) NOT NULL,
            categorie VARCHAR(150) NOT NULL,
            PRIMARY KEY (id))
        ENGINE = InnoDB $charset_collate";
        dbDelta($sql);

        //Create the pleegoudersupport nieuwsletter table
        $sql = "CREATE TABLE IF NOT EXISTS $psnieuwsletter (
            id INT NOT NULL AUTO_INCREMENT,
            email VARCHAR(75) NOT NULL,
            PRIMARY KEY (id))
            ENGINE = InnoDB $charset_collate";
        dbDelta($sql);
    }

    public static function delete_plugin_database_tables()
    {
        global $wpdb;
        $tableArray = [
            $wpdb->prefix . "wp_ps_agenda",
        ];
        $tableArray = [
            $wpdb->prefix . "wp_ps_nieuwsletter",
        ];

        foreach ($tableArray as $tablename) {
            $wpdb->query("DROP TABLE IF EXISTS $tablename");
        }
    }
}

// Instantiate the class
$pleegoudersupport = new pleegoudersupport();
