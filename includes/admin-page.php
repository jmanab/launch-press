<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function lp_admin_page() {

    $site_title = get_bloginfo( 'name' );
    $nickname   = wp_get_current_user()->nickname;

    if ( empty( $site_title ) ) {
        $site_title = 'My Website';
    }

    if ( empty( $nickname ) ) {
        $nickname = 'Editorial Team';
    }

?>
<div class="wrap lp-wrap">

    <div class="lp-header">
        <div>
            <h1>🚀 Launch Press</h1>
            <p>Fresh Install Setup Wizard</p>
        </div>
    </div>

    <form method="post">

        <?php wp_nonce_field( 'lp_apply_settings', 'lp_nonce' ); ?>

        <div class="lp-grid">

            <div class="lp-main">

                <div class="lp-card">
                    <h2>Site Identity</h2>

                    <label>Site Title</label>

                    <input type="text" name="lp_site_title" value="<?php echo esc_attr( $site_title ); ?>">

                    <label>Nickname</label>

                    <input type="text" name="lp_nickname" value="<?php echo esc_attr( $nickname ); ?>">
                </div>

                <div class="lp-card">

                    <h2>Site Nature</h2>

                    <div class="lp-inline">

                        <div>
                            <label>Website Type</label>

                            <select name="lp_site_type">
                                <option value="blog">Blog</option>
                                <option value="news">News</option>
                                <option value="business">Business</option>
                                <option value="affiliate">Affiliate</option>
                            </select>
                        </div>

                        <div>
                            <label>
                                <input type="checkbox" name="lp_blog" checked>
                                Blog Enabled
                            </label>
                        </div>

                        <div>
                            <label>
                                <input type="checkbox" name="lp_comments" checked>
                                Comments Enabled
                            </label>
                        </div>

                    </div>

                </div>

                <div class="lp-card">

                    <h2>Automation Summary</h2>

                    <ul>
                        <li>Theme sanitize</li>
                        <li>Delete all comments</li>
                        <li>Protect username exposure</li>
                        <li>Optimize discussion settings</li>
                        <li>Disable default image sizes</li>
                        <li>Apply SEO permalink structure</li>
                    </ul>

                </div>

            </div>

            <div class="lp-sidebar">

                <div class="lp-card">

                    <h2>Ready</h2>

                    <button type="submit" name="lp_run" class="button button-primary button-hero">
                        Apply Settings
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>
<?php
}
