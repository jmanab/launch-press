<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', 'lp_process_settings' );

function lp_process_settings() {

    if ( ! isset( $_POST['lp_run'] ) ) {
        return;
    }

    if (
        ! isset( $_POST['lp_nonce'] ) ||
        ! wp_verify_nonce( $_POST['lp_nonce'], 'lp_apply_settings' )
    ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    update_option( 'blogname', sanitize_text_field( $_POST['lp_site_title'] ) );

    $user_id = get_current_user_id();

    update_user_meta(
        $user_id,
        'nickname',
        sanitize_text_field( $_POST['lp_nickname'] )
    );

    wp_update_user([
        'ID'           => $user_id,
        'display_name' => sanitize_text_field( $_POST['lp_nickname'] )
    ]);

    update_option( 'users_can_register', 0 );
    update_option( 'timezone_string', 'Asia/Kolkata' );
    update_option( 'date_format', 'd-m-Y' );
    update_option( 'time_format', 'g:i a' );
    update_option( 'rss_use_excerpt', 1 );

    update_option( 'thumbnail_size_w', 0 );
    update_option( 'thumbnail_size_h', 0 );
    update_option( 'medium_size_w', 0 );
    update_option( 'medium_size_h', 0 );
    update_option( 'large_size_w', 0 );
    update_option( 'large_size_h', 0 );

    global $wpdb;

    $comments = get_comments([
        'status' => 'all',
        'number' => 0
    ]);

    foreach ( $comments as $comment ) {
        wp_delete_comment( $comment->comment_ID, true );
    }

    require_once ABSPATH . 'wp-admin/includes/theme.php';

    $themes       = wp_get_themes();
    $active_theme = wp_get_theme();

    $keep = [];

    $keep[] = $active_theme->get_stylesheet();

    if ( $active_theme->parent() ) {
        $keep[] = $active_theme->parent()->get_stylesheet();
    }

    foreach ( $themes as $slug => $theme ) {

        if ( $theme->get( 'Template' ) === $active_theme->get_stylesheet() ) {
            $keep[] = $slug;
        }
    }

    foreach ( $themes as $slug => $theme ) {

        if ( ! in_array( $slug, $keep ) ) {
            delete_theme( $slug );
        }
    }

    flush_rewrite_rules();

    deactivate_plugins( plugin_basename( dirname( __DIR__ ) . '/launch-press.php' ) );

    wp_safe_redirect(
        admin_url( 'plugins.php?deactivate=true' )
    );

    exit;
}
