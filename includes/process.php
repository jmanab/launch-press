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

    $site_title = sanitize_text_field( $_POST['lp_site_title'] ?? '' );
    $nickname   = sanitize_text_field( $_POST['lp_nickname'] ?? '' );

    update_option( 'blogname', $site_title );

    $user_id = get_current_user_id();

    update_user_meta( $user_id, 'nickname', $nickname );

    wp_update_user([
        'ID'           => $user_id,
        'display_name' => $nickname
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

    update_option( 'permalink_structure', '/%postname%/' );

    // localhost indexing block
    $host = $_SERVER['HTTP_HOST'] ?? '';

    if (
        strpos( $host, 'localhost' ) !== false ||
        strpos( $host, '127.0.0.1' ) !== false ||
        strpos( $host, '.local' ) !== false ||
        strpos( $host, '.test' ) !== false ||
        preg_match('/^(192\.168\.|10\.|172\.)/', $host)
    ) {
        update_option( 'blog_public', 0 );
    }



    // delete default content
    $hello_post = get_page_by_title( 'Hello world!', OBJECT, 'post' );

    if ( $hello_post ) {
        wp_delete_post( $hello_post->ID, true );
    }

    $sample_page = get_page_by_title( 'Sample Page', OBJECT, 'page' );

    if ( $sample_page ) {
        wp_delete_post( $sample_page->ID, true );
    }

    // delete hello dolly
    if ( file_exists( WP_PLUGIN_DIR . '/hello.php' ) ) {

        deactivate_plugins( 'hello.php' );

        delete_plugins([
            'hello.php'
        ]);
    }

    // discussion settings
    $comments_enabled = isset( $_POST['lp_comments'] );

    if ( ! $comments_enabled ) {

        update_option( 'default_ping_status', 'closed' );
        update_option( 'default_pingback_flag', 0 );

        update_option( 'default_comment_status', 'closed' );

        update_option( 'require_name_email', 0 );
        update_option( 'comment_registration', 0 );

        update_option( 'close_comments_for_old_posts', 1 );
        update_option( 'close_comments_days_old', 14 );

        update_option( 'show_comments_cookies_opt_in', 0 );

        update_option( 'thread_comments', 0 );
        update_option( 'thread_comments_depth', 3 );

        update_option( 'page_comments', 0 );

        update_option( 'comments_notify', 0 );
        update_option( 'moderation_notify', 0 );

        update_option( 'comment_moderation', 1 );
        update_option( 'comment_whitelist', 0 );

        update_option( 'show_avatars', 0 );

    } else {

        update_option( 'default_ping_status', 'closed' );
        update_option( 'default_pingback_flag', 0 );

        update_option( 'default_comment_status', 'open' );

        update_option( 'require_name_email', 1 );
        update_option( 'comment_registration', 0 );

        update_option( 'close_comments_for_old_posts', 1 );
        update_option( 'close_comments_days_old', 30 );

        update_option( 'show_comments_cookies_opt_in', 0 );

        update_option( 'thread_comments', 1 );
        update_option( 'thread_comments_depth', 3 );

        update_option( 'page_comments', 0 );

        update_option( 'comments_notify', 0 );
        update_option( 'moderation_notify', 1 );

        update_option( 'comment_moderation', 1 );
        update_option( 'comment_whitelist', 0 );

        update_option( 'show_avatars', 0 );

        update_option( 'avatar_default', 'blank' );
    }

    // delete comments
    $comments = get_comments([
        'status' => 'all',
        'number' => 0
    ]);

    foreach ( $comments as $comment ) {
        wp_delete_comment( $comment->comment_ID, true );
    }

    // theme sanitize
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

    wp_safe_redirect( admin_url( 'plugins.php' ) );
    exit;
}
