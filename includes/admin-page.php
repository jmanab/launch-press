<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function lp_admin_page() {

    $site_title = get_bloginfo( 'name' );
    $nickname   = wp_get_current_user()->nickname;

    if ( empty( $site_title ) ) {
        $site_title = 'My Website';
    }

    if ( empty( $nickname ) ) {
        $nickname = ! empty( $site_title ) ? $site_title : 'Website Team';
    }

?>
<div class="wrap lp-wrap">

    <div class="lp-topbar">

        <div class="lp-brand">
            <div class="lp-logo">🚀</div>

            <div>
                <h1>Launch Press</h1>
                <p>Fresh WordPress Setup Automation Utility</p>
            </div>
        </div>

        <div class="lp-alert">
            This plugin applies essential fresh-install optimizations and automatically deactivates after completion.
        </div>

    </div>

    <form method="post">

        <?php wp_nonce_field( 'lp_apply_settings', 'lp_nonce' ); ?>

        <div class="lp-grid">

            <div class="lp-main">

                <div class="lp-card">

                    <div class="lp-card-head">
                        <h2>Site Identity</h2>
                        <span>Basic website information</span>
                    </div>

                    <div class="lp-two">

                        <div>
                            <label>Site Title</label>

                            <input type="text" name="lp_site_title" value="<?php echo esc_attr( $site_title ); ?>">
                        </div>

                        <div>
                            <label>Nickname</label>

                            <input type="text" name="lp_nickname" value="<?php echo esc_attr( $nickname ); ?>">
                        </div>

                    </div>

                </div>

                <div class="lp-card">

                    <div class="lp-card-head">
                        <h2>Site Nature</h2>
                        <span>Controls homepage & blog structure</span>
                    </div>

                    <div class="lp-three">

                        <div>
                            <label>Website Type</label>

                            <select name="lp_site_type">
                                <option value="website">Website</option>
                                <option value="website_blog" selected>Website + Blog</option>
                                <option value="blog_only">Blog Only</option>
                            </select>
                        </div>

                        <div>
                            <label>Comments</label>

                            <select name="lp_comments">
                                <option value="yes" selected>Enabled</option>
                                <option value="no">Disabled</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div class="lp-card">

                    <div class="lp-card-head">
                        <h2>Automation Tasks</h2>
                        <span>Tasks Launch Press will perform</span>
                    </div>

                    <div class="lp-task-grid">

                        <div class="lp-task">
                            <h3>Cleanup</h3>

                            <ul>
                                <li>Delete Hello World post</li>
                                <li>Delete Sample Page</li>
                                <li>Delete Hello Dolly plugin</li>
                                <li>Delete all comments</li>
                                <li>Remove unused themes</li>
                            </ul>
                        </div>

                        <div class="lp-task">
                            <h3>Optimization</h3>

                            <ul>
                                <li>SEO permalink structure</li>
                                <li>Feed excerpt optimization</li>
                                <li>Disable default image sizes</li>
                                <li>Discussion optimization</li>
                                <li>Localhost indexing protection</li>
                            </ul>
                        </div>

                        <div class="lp-task">
                            <h3>Pages & Reading</h3>

                            <ul>
                                <li>Create essential pages</li>
                                <li>Configure homepage</li>
                                <li>Configure blog page</li>
                                <li>Apply reading settings</li>
                                <li>Apply page ordering</li>
                            </ul>
                        </div>

                        <div class="lp-task">
                            <h3>Security</h3>

                            <ul>
                                <li>Protect username exposure</li>
                                <li>Apply nickname display</li>
                                <li>Disable risky defaults</li>
                                <li>Reduce spam vectors</li>
                                <li>Safer baseline setup</li>
                            </ul>
                        </div>

                    </div>

                </div>

                <div class="lp-warning">

                    <h3>⚠ Before Execute</h3>

                    <ul>
                        <li>This action will modify WordPress settings automatically.</li>
                        <li>Unused themes and default content will be removed.</li>
                        <li>Plugin is designed for fresh WordPress installations.</li>
                        <li>Plugin will auto-deactivate after completion.</li>
                    </ul>

                </div>

            </div>

            <div class="lp-sidebar">

                <div class="lp-sidecard">

                    <h2>Execution Summary</h2>

                    <ul>
                        <li>✔ Configure General Settings</li>
                        <li>✔ Configure Reading Settings</li>
                        <li>✔ Configure Discussion Settings</li>
                        <li>✔ Create Essential Pages</li>
                        <li>✔ Configure Homepage</li>
                        <li>✔ Optimize Media Settings</li>
                        <li>✔ Theme Cleanup</li>
                        <li>✔ Username Protection</li>
                        <li>✔ Localhost SEO Protection</li>
                    </ul>

                </div>

                <div class="lp-sidecard lp-blue">

                    <h2>Ready to Apply</h2>

                    <p>
                        Launch Press will now apply all selected baseline optimizations and automatically deactivate itself after completion.
                    </p>

                    <label class="lp-consent">
                        <input type="checkbox" name="lp_confirm" required>
                        I understand Launch Press will modify settings and remove default content.
                    </label>

                    <button type="submit" name="lp_run" class="lp-btn">
                        Apply Settings
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>
<?php
}
