<?php
/**
 * Theme Options
 *
 * @package WordPress
 * @subpackage PJFitz
 * @since PJFitz 1.0
 */

/**
 * Add Theme Options to admin menu
 */
function register_theme_options() {
    add_submenu_page(
            'themes.php', 'Theme Options', 'Theme Options', 'manage_categories', 'new-theme-options', 'callback_theme_options'
    );
}

add_action('admin_menu', 'register_theme_options');

/**
 * Display page content
 */
function callback_theme_options() {
    if (isset($_POST['update'])) {

        // Remove magic quotes
        $_POST = array_map('stripslashes_deep', $_POST);

        // Set variables from post
        $org_type = esc_attr($_POST['org-type']);
        $name = esc_attr($_POST['name']);
        $url = esc_attr($_POST['url']);
        $addr = esc_attr($_POST['addr']);
        $po = esc_attr($_POST['po']);
        $city = esc_attr($_POST['city']);
        $state = esc_attr($_POST['state']);
        $zip = esc_attr($_POST['zip']);
        $country = esc_attr($_POST['country']);
        $tel = esc_attr($_POST['tel']);
        $fax = esc_attr($_POST['fax']);
        $email = esc_attr($_POST['email']);
        $hours = esc_attr($_POST['hours']);
        $map_url = esc_attr($_POST['map_url']);
        $map = esc_attr($_POST['map']);
        $revslider = esc_attr($_POST['revolution_slider']);

        $logo_src = esc_attr($_POST['logo-src']);
        $logo_alt = esc_attr($_POST['logo-alt']);

        $logo_src_scroll = esc_attr($_POST['logo-src-scroll']);
        $logo_alt_scroll = esc_attr($_POST['logo-alt-scroll']);

        $logo_footer_src = esc_attr($_POST['logo_footer_src']);
        $logo_footer_alt_src = esc_attr($_POST['logo_footer_alt_src']);

        $logo_src_r = esc_attr($_POST['logo-src_r']);
        $logo_alt_r = esc_attr($_POST['logo-alt_r']);

        $favicon = esc_attr($_POST['favicon']);

        $bg_src = esc_attr($_POST['bg-src']);
        $bg_alt = esc_attr($_POST['bg-alt']);

        $contact_form = esc_attr($_POST['contact_form']);

        $facebook = esc_attr($_POST['facebook']);
        $instagram = esc_attr($_POST['instagram']);
        $twitter = esc_attr($_POST['twitter']);
        $googleplus = esc_attr($_POST['googleplus']);
        $youtube = esc_attr($_POST['youtube']);
        $linkedin = esc_attr($_POST['linkedin']);
        $pinterest = esc_attr($_POST['pinterest']);
        $tumblr = esc_attr($_POST['tumblr']);
        $rss = esc_attr($_POST['rss']);

        $header = $_POST['header'];
        $footer = $_POST['footer'];

        // Save options
        update_option('theme_options_org_type', $org_type);
        update_option('theme_options_name', $name);
        update_option('theme_options_url', $url);
        update_option('theme_options_addr', $addr);
        update_option('theme_options_po', $po);
        update_option('theme_options_city', $city);
        update_option('theme_options_state', $state);
        update_option('theme_options_zip', $zip);
        update_option('theme_options_country', $country);
        update_option('theme_options_tel', $tel);
        update_option('theme_options_fax', $fax);
        update_option('theme_options_email', $email);
        update_option('theme_options_hours', $hours);
        update_option('theme_options_map_url', $map_url);
        update_option('theme_options_map', $map);
        update_option('theme_options_revslider', $revslider);

        update_option('theme_options_logo_src', $logo_src);
        update_option('theme_options_logo_alt', $logo_alt);

        update_option('theme_options_logo_src_scroll', $logo_src_scroll);
        update_option('theme_options_logo_alt_scroll', $logo_alt_scroll);

        update_option('theme_options_logo_footer_src', $logo_footer_src);
        update_option('theme_options_logo_footer_alt_src', $logo_footer_alt_src);

        update_option('theme_options_logo_src_r', $logo_src_r);
        update_option('theme_options_logo_alt_r', $logo_alt_r);

        update_option('theme_options_favicon', $favicon);

        update_option('theme_options_bg_src', $bg_src);
        update_option('theme_options_bg_alt', $bg_alt);

        update_option('theme_options_contact_form', $contact_form);

        update_option('theme_options_facebook', $facebook);
        update_option('theme_options_instagram', $instagram);
        update_option('theme_options_twitter', $twitter);
        update_option('theme_options_googleplus', $googleplus);
        update_option('theme_options_youtube', $youtube);
        update_option('theme_options_linkedin', $linkedin);
        update_option('theme_options_pinterest', $pinterest);
        update_option('theme_options_tumblr', $tumblr);
        update_option('theme_options_rss', $rss);

        update_option('theme_options_header', $header);
        update_option('theme_options_footer', $footer);

        // Display message
        echo '<div id="message" class="updated"><p><strong>Settings saved.</strong></p></div>';
    } else {

        // Set variables from database
        $org_type = get_option('theme_options_org_type');
        $name = get_option('theme_options_name');
        $url = get_option('theme_options_url');
        $addr = get_option('theme_options_addr');
        $po = get_option('theme_options_po');
        $city = get_option('theme_options_city');
        $state = get_option('theme_options_state');
        $zip = get_option('theme_options_zip');
        $country = get_option('theme_options_country');
        $tel = get_option('theme_options_tel');
        $fax = get_option('theme_options_fax');
        $email = get_option('theme_options_email');
        $hours = get_option('theme_options_hours');
        $map_url = get_option('theme_options_map_url');
        $map = get_option('theme_options_map');
        $revslider = get_option('theme_options_revslider');

        $logo_src = get_option('theme_options_logo_src');
        $logo_alt = get_option('theme_options_logo_alt');

        $logo_src_scroll = get_option('theme_options_logo_src_scroll');
        $logo_alt_scroll = get_option('theme_options_logo_alt_scroll');

        $logo_footer_src = get_option('theme_options_logo_footer_src');
        $logo_footer_alt_src = get_option('theme_options_footer_alt_src');

        $logo_src_r = get_option('theme_options_logo_src_r');
        $logo_alt_r = get_option('theme_options_logo_alt_r');

        $favicon = get_option('theme_options_favicon');

        $bg_src = get_option('theme_options_bg_src');
        $bg_alt = get_option('theme_options_bg_alt');

        $contact_form = get_option('theme_options_contact_form');

        $facebook = get_option('theme_options_facebook');
        $instagram = get_option('theme_options_instagram');
        $twitter = get_option('theme_options_twitter');
        $googleplus = get_option('theme_options_googleplus');
        $youtube = get_option('theme_options_youtube');
        $linkedin = get_option('theme_options_linkedin');
        $pinterest = get_option('theme_options_pinterest');
        $tumblr = get_option('theme_options_tumblr');
        $rss = get_option('theme_options_rss');

        $header = get_option('theme_options_header');
        $footer = get_option('theme_options_footer');
    }
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Theme Options</h2>
        <?php settings_errors(); ?>

        <form action="" method="post">
            <h3>Contact Information</h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="org-type">Type of Organization:</label>
                    </th>
                    <td>
                        <select id="org-type" name="org-type">
                            <option value="Organization"<?php if ($org_type == 'Organization') echo ' selected="selected"'; ?>>General</option>
                            <option value="Corporation"<?php if ($org_type == 'Corporation') echo ' selected="selected"'; ?>>Corporation</option>
                            <option value="EducationalOrganization"<?php if ($org_type == 'EducationalOrganization') echo ' selected="selected"'; ?>>School</option>
                            <option value="GovernmentOrganization"<?php if ($org_type == 'GovernmentOrganization') echo ' selected="selected"'; ?>>Government</option>
                            <option value="LocalBusiness"<?php if ($org_type == 'LocalBusiness') echo ' selected="selected"'; ?>>Local Business</option>
                            <option value="NGO"<?php if ($org_type == 'NGO') echo ' selected="selected"'; ?>>NGO</option>
                            <option value="PerformingGroup"<?php if ($org_type == 'PerformingGroup') echo ' selected="selected"'; ?>>Performing Group</option>
                            <option value="SportsTeam"<?php if ($org_type == 'SportsTeam') echo ' selected="selected"'; ?>>Sports Team</option>
                        </select>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="name">Name:</label>
                    </th>
                    <td>
                        <input type="text" id="name" name="name" size="50" value="<?php echo $name; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="url">URL:</label>
                    </th>
                    <td>
                        <input type="text" id="url" name="url" size="50" value="<?php echo $url; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="addr">Street Address:</label>
                    </th>
                    <td>
                        <input type="text" id="addr" name="addr" size="50" value="<?php echo $addr; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="po">PO Box:</label>
                    </th>
                    <td>
                        <input type="text" id="po" name="po" size="50" value="<?php echo $po; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="city">City:</label>
                    </th>
                    <td>
                        <input type="text" id="city" name="city" size="50" value="<?php echo $city; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="state">State/Region:</label>
                    </th>
                    <td>
                        <input type="text" id="state" name="state" size="50" value="<?php echo $state; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="zip">Postal Code:</label>
                    </th>
                    <td>
                        <input type="text" id="zip" name="zip"  size="50" value="<?php echo $zip; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="country">Country:</label>
                    </th>
                    <td>
                        <input type="text" id="country" name="country" size="50" value="<?php echo $country; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="tel">Phone Number:</label>
                    </th>
                    <td>
                        <input type="text" id="tel" name="tel"  size="50" value="<?php echo $tel; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="fax">Fax Number:</label>
                    </th>
                    <td>
                        <input type="text" id="fax" name="fax"  size="50" value="<?php echo $fax; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="email">Email Address:</label>
                    </th>
                    <td>
                        <input type="text" id="email" name="email" size="50" value="<?php echo $email; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="hours">Hours:</label>
                    </th>
                    <td>
                        <textarea id="hours" name="hours" cols="52" rows="5"><?php echo $hours; ?></textarea>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="map">Google Map:</label>
                    </th>
                    <td>
                        <textarea id="map" name="map" cols="52" rows="5"><?php echo $map; ?></textarea>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="revslider">Revolution slider:</label>
                    </th>
                    <td>
                        <input type="text" id="revslider" name="revolution_slider" size="50" value="<?php echo $revslider; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>

            <hr />

            <h3>Global</h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="logo-src">Logo:</label>
                    </th>
                    <td>
                        <input type="text" id="logo-src" name="logo-src" class="src" value="<?php echo $logo_src; ?>" />
                        <input type="text" placeholder="Alt" id="logo-alt" name="logo-alt" class="alt" value="<?php echo $logo_alt; ?>" />
                        <input type="button" id="logo-btn" class="upload-button button" value="Add Image" />
                        <a href="#" class="upload-reset">Remove</a>
                    </td>
                </tr>
                <?php if (!empty($logo_src)) : ?>
                    <tr valign="top">
                        <td>&nbsp;</td>
                        <td><img src="<?php echo $logo_src; ?>" alt="<?php echo $logo_alt; ?>" /></td>
                    </tr>
                <?php endif; ?>
            </table>

            <hr />

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="logo-src-scroll">Logo scroll:</label>
                    </th>
                    <td>
                        <input type="text" id="logo-src-scroll" name="logo-src-scroll" class="src" value="<?php echo $logo_src_scroll; ?>" />
                        <input type="hidden" id="logo-alt-scroll" name="logo-alt-scroll" class="alt" value="<?php echo $logo_alt_scroll; ?>" />
                        <input type="button" id="logo-btn-scroll" class="upload-button button" value="Add Image" />
                        <a href="#" class="upload-reset">Remove</a>
                    </td>
                </tr>
                <?php if (!empty($logo_src_scroll)) : ?>
                    <tr valign="top">
                        <td>&nbsp;</td>
                        <td><img src="<?php echo $logo_src_scroll; ?>" alt="<?php echo $logo_alt_scroll; ?>" /></td>
                    </tr>
                <?php endif; ?>
            </table>

            <hr />

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="logo_footer_src">Logo Footer:</label>
                    </th>
                    <td>
                        <input type="text" id="logo_footer_src" name="logo_footer_src" class="src" value="<?php echo $logo_footer_src; ?>" />
                        <input type="hidden" id="logo_footer_alt_src" name="logo_footer_alt_src" class="alt" value="<?php echo $logo_footer_alt_src; ?>" />
                        <input type="button" id="logo_footer_alt_src" class="upload-button button" value="Add Image" />
                        <a href="#" class="upload-reset">Remove</a>
                    </td>
                </tr>
                <?php if (!empty($logo_src_r)) : ?>
                    <tr valign="top">
                        <td>&nbsp;</td>
                        <td><img src="<?php echo $logo_src_r; ?>" alt="<?php echo $logo_alt_r; ?>" /></td>
                    </tr>
                <?php endif; ?>
            </table>

            <hr />

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="logo-src_r">Logo Responsive:</label>
                    </th>
                    <td>
                        <input type="text" id="logo-src_r" name="logo-src_r" class="src" value="<?php echo $logo_src_r; ?>" />
                        <input type="hidden" id="logo-alt_r" name="logo-alt_r" class="alt" value="<?php echo $logo_alt_r; ?>" />
                        <input type="button" id="logo-btn_r" class="upload-button button" value="Add Image" />
                        <a href="#" class="upload-reset">Remove</a>
                    </td>
                </tr>
                <?php if (!empty($logo_src_r)) : ?>
                    <tr valign="top">
                        <td>&nbsp;</td>
                        <td><img src="<?php echo $logo_src_r; ?>" alt="<?php echo $logo_alt_r; ?>" /></td>
                    </tr>
                <?php endif; ?>
            </table>

            <hr />

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="favicon">Favicon:</label>
                    </th>
                    <td>
                        <input type="text" id="favicon" name="favicon" class="src" value="<?php echo $favicon; ?>" />
                        <input type="button" id="favicon_upload" class="upload-button button" value="Add Image" />
                        <a href="#" class="upload-reset">Remove</a>
                    </td>
                </tr>
                <?php if (!empty($favicon)) : ?>
                    <tr valign="top">
                        <td>&nbsp;</td>
                        <td><img src="<?php echo $favicon; ?>"/></td>
                    </tr>
                <?php endif; ?>
            </table>

            <hr />

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="contact_form">Contact form:</label>
                    </th>
                    <td>
                        <input type="text" id="contact_form" name="contact_form" size="50" value="<?php echo $contact_form; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>

            <hr />

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="logo-bg">Background:</label>
                    </th>
                    <td>
                        <input type="text" id="bg-src" name="bg-src" class="src" value="<?php echo $bg_src; ?>" />
                        <input type="hidden" id="bg-alt" name="bg-alt" class="alt" value="<?php echo $bg_alt; ?>" />
                        <input type="button" id="bg-btn" class="upload-button button" value="Add Image" />
                        <a href="#" class="upload-reset">Remove</a>
                    </td>
                </tr>
                <?php if (!empty($bg_src)) : ?>
                    <tr valign="top">
                        <td>&nbsp;</td>
                        <td><img src="<?php echo $bg_src; ?>" alt="<?php echo $bg_alt; ?>" style="max-width: 500px;"/></td>
                    </tr>
                <?php endif; ?>
            </table>

            <?php submit_button(); ?>

            <hr />

            <h3>Social Media</h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="facebook">Facebook URL:</label>
                    </th>
                    <td>
                        <input type="text" id="facebook" name="facebook" size="50" value="<?php echo $facebook; ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="instagram">Instagram URL:</label>
                    </th>
                    <td>
                        <input type="text" id="instagram" name="instagram" size="50" value="<?php echo $instagram; ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="twitter">Twitter URL:</label>
                    </th>
                    <td>
                        <input type="text" id="twitter" name="twitter" size="50" value="<?php echo $twitter; ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="googleplus">Google+ URL:</label>
                    </th>
                    <td>
                        <input type="text" id="googleplus" name="googleplus" size="50" value="<?php echo $googleplus; ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="youtube">YouTube URL:</label>
                    </th>
                    <td>
                        <input type="text" id="youtube" name="youtube" size="50" value="<?php echo $youtube; ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="linkedin">LinkedIn URL:</label>
                    </th>
                    <td>
                        <input type="text" id="linkedin" name="linkedin" size="50" value="<?php echo $linkedin; ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="pinterest">Pinterest URL:</label>
                    </th>
                    <td>
                        <input type="text" id="pinterest" name="pinterest" size="50" value="<?php echo $pinterest; ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="tumblr">Tumblr URL:</label>
                    </th>
                    <td>
                        <input type="text" id="tumblr" name="tumblr" size="50" value="<?php echo $tumblr; ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="rss">RSS URL:</label>
                    </th>
                    <td>
                        <input type="text" id="rss" name="rss" size="50" value="<?php echo $rss; ?>" />
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>

            <hr />

            <h3>Header</h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="header">Content:</label>
                    </th>
                    <td>
                        <?php
                        // Display editor
                        $args = array(
                            'media_buttons' => true,
                        );
                        wp_editor($header, 'header', $args);
                        ?>
                    </td>
                </tr>
            </table>

            <h3>Footer</h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="footer">Content:</label>
                    </th>
                    <td>
                        <?php
                        // Display editor
                        $args = array(
                            'media_buttons' => true,
                        );
                        wp_editor($footer, 'footer', $args);
                        ?>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>

            <input type="hidden" name="update" value="1" />
        </form>
    </div>
    <?php
}
?>