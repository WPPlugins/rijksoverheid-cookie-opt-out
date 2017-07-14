<?php
/**
 * @package Rijksoverheid Cookie Opt-Out v2.0
 * @version 0.2
 */

/*
Plugin Name: Rijksoverheid Cookie Opt-Out v2.0
Version: 0.2
Plugin URI: http://www.forsitemedia.nl/plugins/rijksoverheid-cookie-opt-out/
Description: Rijksoverheid Cookie Opt-Out v2.0 plugin voor WordPress
Author: Forsite Media
Author URI: http://www.forsitemedia.nl/
Domain Path: /languages/
License: GPL v3

Rijksoverheid Cookie Opt-Out v2.0
Copyright (C) 2013, Forsite Media  - info@forsite.nu
					Rijksoverheid.nl

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

add_action( 'wp_enqueue_scripts', 'fs_rijksoverheid_cookie_scripts' );
/**
 * Enqueue style and script
 */
function fs_rijksoverheid_cookie_scripts() {

	// Enqueue stylesheet
	if ( get_option( 'fs_rijksoverheid_cookies_enqueue_style' ) == 1 )
		wp_enqueue_style( 'rijksoverheid-cookies', plugin_dir_url( __FILE__ ) . 'lib/css/screen-cookies.min.css', false, '1.0', 'all' );

	// Enqueue script
	wp_enqueue_script( 'rijksoverheid-cookies', plugin_dir_url( __FILE__ ) . 'lib/js/cookies.min.js', array(), '1.0', true );

	wp_localize_script( 'rijksoverheid-cookies', 'rijksoverheid_cookiebar_init_vars', array(
			'text'      => get_option( 'fs_rijksoverheid_cookies_text' ) . ' ', // Add trailing space because saving options removes trailing spaces for some reason.
			'url'       => get_option( 'fs_rijksoverheid_cookies_url' ),
			'urltext'   => get_option( 'fs_rijksoverheid_cookies_urltext' ),
			'cookielog' => plugin_dir_url( __FILE__ ) . 'lib/images/'
		)
	);
}


add_action( 'admin_init', 'fs_rijksoverheid_cookies_register_settings' );
/**
 * Add and register options
 */
function fs_rijksoverheid_cookies_register_settings() {
	add_option( 'fs_rijksoverheid_cookies_enqueue_style', '1' );
	register_setting( 'rijksoverheid_cookie_options', 'fs_rijksoverheid_cookies_enqueue_style' );

	$fs_rijksoverheid_cookies = array(
		'text'    => 'Rijksoverheid.nl gebruikt cookies om het gebruik van de website te analyseren en het gebruiksgemak te verbeteren. Lees meer over',
		'url'     => '/cookies/',
		'urltext' => 'cookies'
	);

	add_option( 'fs_rijksoverheid_cookies_text', $fs_rijksoverheid_cookies['text'] );
	register_setting( 'rijksoverheid_cookie_options', 'fs_rijksoverheid_cookies_text' );

	add_option( 'fs_rijksoverheid_cookies_url', $fs_rijksoverheid_cookies['url'] );
	register_setting( 'rijksoverheid_cookie_options', 'fs_rijksoverheid_cookies_url' );

	add_option( 'fs_rijksoverheid_cookies_urltext', $fs_rijksoverheid_cookies['urltext'] );
	register_setting( 'rijksoverheid_cookie_options', 'fs_rijksoverheid_cookies_urltext' );
}


add_action( 'admin_menu', 'fs_rijksoverheid_cookies_register_options_page' );
/**
 * Add options page
 */
function fs_rijksoverheid_cookies_register_options_page() {
	add_options_page( 'Rijksoverheid Cookie Opt-Out', 'Rijksoverheid Cookie Opt-Out', 'manage_options', 'rijksoverheid-cookies-options', 'fs_rijksoverheid_cookies_options_page' );
}


/**
 * Options page
 */
function fs_rijksoverheid_cookies_options_page() {
?>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Rijksoverheid Cookie Opt-Out</h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'rijksoverheid_cookie_options' ); ?>
		<h3>Cookiebar instellingen</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="fs_rijksoverheid_cookies_text">Cookiebar tekst</label></th>
				<td><input type="text" id="fs_rijksoverheid_cookies_text" name="fs_rijksoverheid_cookies_text" value="<?php echo get_option( 'fs_rijksoverheid_cookies_text' ); ?>" class="large-text" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="fs_rijksoverheid_cookies_url">Cookiebar url</label></th>
				<td><input type="text" id="fs_rijksoverheid_cookies_url" name="fs_rijksoverheid_cookies_url" value="<?php echo get_option( 'fs_rijksoverheid_cookies_url' ); ?>" class="regular-text" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="fs_rijksoverheid_cookies_urltext">Cookiebar url tekst</label></th>
				<td><input type="text" id="fs_rijksoverheid_cookies_urltext" name="fs_rijksoverheid_cookies_urltext" value="<?php echo get_option( 'fs_rijksoverheid_cookies_urltext' ); ?>" class="regular-text" /></td>
			</tr>
		</table>
		<h3>Stylesheet instellingen</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="fs_rijksoverheid_cookies_enqueue_style">Stylesheet inladen?</label></th>
				<td>
					<input type="checkbox" id="fs_rijksoverheid_cookies_enqueue_style" name="fs_rijksoverheid_cookies_enqueue_style" value="1" <?php checked( get_option( 'fs_rijksoverheid_cookies_enqueue_style' ), 1 ); ?> />
					<span class="description">Vink de checkbox uit om het stylesheet uit te schakelen.</span>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
	<h3>Stylesheet referentie</h3>
<pre>
.cookie {
	width: 960px;
	margin: 0 auto;
	padding-bottom: 10px;
	background: url(../images/cookiebar-shadow-end.png) no-repeat 0 100%; /* Bottom background with shadow */
	position: relative;
}
.cookie p {
	margin: 0;
	padding: 8px 20px 12px;
	background: url(../images/cookiebar-shadow-repeater.png) repeat-y; /* Main lightgreen background with shadow */
	font: 1em/1.2 'Verdana','Geneva',sans-serif;
}
.cookie p a {
	text-decoration: underline;
}

/* IE Fixes */
* html .cookie {
	position: absolute;
	height: 1%;
}
</pre>
</div>
<?php
}
