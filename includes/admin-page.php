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

            <div class="lp-note">
                This plugin applies essential baseline settings and auto-deactivates after completion.
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
                    </div>

                    <div class="lp-card">
                        <h2>Site Nature</h2>

                        <div class="lp-inline">
                            <div>
                                <label>Website Type</label>

                                <select name="lp_site_type">
                                    <option>Blog</option>
                                    <option>News</option>
                                    <option>Business</option>
                                    <option>Affiliate</option>
                                    <option>Portfolio</option>
                                    <option>Directory</option>
                                    <option>WooCommerce</option>
                                </select>
                            </div>

                            <div>
                                <label>
                                    <input type="checkbox" checked>
                                    Blog Enabled
                                </label>
                            </div>

                            <div>
                                <label>
                                    <input type="checkbox" checked>
                                    Comments Enabled
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="lp-card">
                        <h2>Cleanup Modules</h2>

                        <ul>
                            <li>✔ Theme sanitize</li>
                            <li>✔ Delete all comments</li>
                            <li>✔ Username exposure protection</li>
                            <li>✔ Discussion optimization</li>
                            <li>✔ Media size cleanup</li>
                        </ul>
                    </div>

                    <div class="lp-card">
                        <h2>Profile & Security</h2>

                        <label>Nickname</label>
                        <input type="text" name="lp_nickname" value="<?php echo esc_attr( $nickname ); ?>">

                        <p class="description">
                            Public author name will use nickname instead of username.
                        </p>
                    </div>

                    <div class="lp-card">
                        <h2>Default Settings</h2>

                        <ul>
                            <li>Membership: OFF</li>
                            <li>Timezone: Asia/Kolkata</li>
                            <li>Date Format: d-m-Y</li>
                            <li>Permalink: /%postname%/</li>
                            <li>Feed Content: Excerpt</li>
                        </ul>
                    </div>

                    <div class="lp-card">
                        <h2>Discussion</h2>

                        <p>
                            Discussion settings will be automatically optimized based on selected site nature.
                        </p>
                    </div>

                </div>

                <div class="lp-sidebar">

                    <div class="lp-card">
                        <h2>Ready to Apply</h2>

                        <p>
                            Launch Press will apply all selected baseline settings and then self-deactivate.
                        </p>

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
