<?php
/**
 * Plugin Name: Launch Press
 * Plugin URI: https://github.com/jmanab/Launch-press
 * Description: Fresh WordPress install setup automation utility.
 * Version: 1.3.0
 * Author: Manabendra Jha
 * Author URI: https://technotizia.com/
 * License: GPL-3.0+
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: launch-press
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
