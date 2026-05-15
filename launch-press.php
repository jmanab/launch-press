<?php
/**
 * Plugin Name: Launch Press
 * Description: Fresh WordPress install setup automation utility.
 * Version: 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'LP_VERSION', '1.0.1' );
define( 'LP_PATH', plugin_dir_path( __FILE__ ) );
define( 'LP_URL', plugin_dir_url( __FILE__ ) );

require_once LP_PATH . 'includes/admin-page.php';
require_once LP_PATH . 'includes/process.php';

class LaunchPress {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'menu' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );
    }

    public function menu() {

        add_menu_page(
            'Launch Press',
            'Launch Press',
            'manage_options',
            'launch-press',
            'lp_admin_page',
            'dashicons-superhero',
            2
        );
    }

    public function assets() {

        wp_enqueue_style(
            'launch-press-admin',
            LP_URL . 'assets/admin.css',
            [],
            LP_VERSION
        );
    }
}

new LaunchPress();
