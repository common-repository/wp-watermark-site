<?php
/**
 * Plugin Name: WP Watermark Site
 * Plugin URI: http://chrisjoseph.org/wp-watermark-site
 * Description: Add any image or custom text as a watermark for your entire WordPress site.
 * Version: 1.4.1
 * Author: Chris Joseph
 * Author URI: http://chrisjoseph.org
 * License: GPL2
 * Text Domain: wp-watermark-site
 * Domain Path: /languages/
 */

 
 //i18n
load_plugin_textdomain( 'wp-watermark-site', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
add_action( 'plugins_loaded', 'load_plugin_textdomain' );

 
// load watermark font and styles
add_action( 'wp_enqueue_scripts', 'wp_watermark_site_enqueued_assets' );
function wp_watermark_site_enqueued_assets() {
	wp_enqueue_style( 'wp_watermark_site_font', '//fonts.googleapis.com/css?family=Roboto:700' );
	wp_enqueue_style( 'wp_watermark_site_style', plugin_dir_url( __FILE__ ) . 'css/style-1.4.0.css', false, '1.4.0');
}


// enqueue WP image uploader
add_action('admin_enqueue_scripts', 'wp_watermark_site_admin_scripts');
function wp_watermark_site_admin_scripts() {
        wp_enqueue_media();
    }

	
//settings link	
function wp_watermark_site_settings_link($links) { 
  $wpws_settings_link = '<a href="admin.php?page=wp-watermark-settings">Settings</a>'; 
  array_unshift($links, $wpws_settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'wp_watermark_site_settings_link' );


// add watermark to site

add_action( 'wp_footer', 'wp_watermark_site_watermark' );

function wp_watermark_site_watermark() {

	// IF WATERMARKING IS TURNED ON
	if (get_option('wp_watermark_site_watermark_on')=="1"){ 
	
		// opacity
		if (!get_option('wp_watermark_site_opacity')||(get_option('wp_watermark_site_opacity')<0)||(get_option('wp_watermark_site_opacity')>1)){
			$watermarkopacity="0.5";
		} else {
			$watermarkopacity=get_option('wp_watermark_site_opacity');
		}
		
		// z-index
		if (!get_option('wp_watermark_site_zindex')){
			$watermarkzindex="9999";
		} else {
			$watermarkzindex=get_option('wp_watermark_site_zindex');
		}
		
		// font family
		if (!get_option('wp_watermark_site_text_font')){
			$watermarktextfont="roboto,arial,sans-serif";
		} else {
			$watermarktextfont=get_option('wp_watermark_site_text_font');
		}

		// font size
		if (!get_option('wp_watermark_site_text_size')||(get_option('wp_watermark_site_text_size')<0)){
			$watermarktextsize="100";
		} else {
			$watermarktextsize=get_option('wp_watermark_site_text_size');
		}
		
		// image size
		if (!get_option('wp_watermark_site_image_size')||(get_option('wp_watermark_site_image_size')<0)||(get_option('wp_watermark_site_image_size')==" ")||(get_option('wp_watermark_site_image_size')=="")){
			$watermarkimagesize="auto";
		} else {
			$watermarkimagesize=get_option('wp_watermark_site_image_size');
		}

		// position
		if (!get_option('wp_watermark_site_position')||(get_option('wp_watermark_site_position')=="")){
			$positionclass="bottomleft";
		} else {
		$positionclass = get_option('wp_watermark_site_position');
		}

		// color
		if (!get_option('wp_watermark_site_color')){
			$wp_watermark_site_text_color="#000";
		} else {
			$wp_watermark_site_text_color = get_option('wp_watermark_site_color');
		}
		
		// EITHER display text watermark
		if (get_option('wp_watermark_site_text_on')=="1"){
			$wp_watermark_site_text_string=get_option('wp_watermark_site_text');
			if ($wp_watermark_site_text_string==""){
				$wp_watermark_site_text_string="WP<br><strong>Watermark</strong><br>Site";
			}
			
		$watermarkstring = "<div id='wp-watermark' class='watermark-".$positionclass."' style='opacity:".$watermarkopacity.";color:".$wp_watermark_site_text_color."'>".$wp_watermark_site_text_string;
		$watermarkstring = "<div id='wp-watermark' class='watermark-".$positionclass."' style='opacity:".$watermarkopacity.";color:".$wp_watermark_site_text_color.";font-size:".$watermarktextsize.";font-family:".$watermarktextfont.";'>".$wp_watermark_site_text_string;
		}
		
		// OR display image watermark
		if (get_option('wp_watermark_site_image_on')=="1"){
			$watermarkimage=get_option('wp_watermark_site_image_url');
			
			if ($watermarkimage==""){
				$watermarkimage="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Copyright.svg/600px-Copyright.svg.png";
			}
			
			$watermarkstring = "<div id='wp-watermark' class='watermark-".$positionclass."' style='opacity:".$watermarkopacity.";'><img src='".$watermarkimage."' style='width:".$watermarkimagesize.";'>";
		}
		
		
		echo "<div id='wp-watermark-holder' style='z-index:".$watermarkzindex.";'>".$watermarkstring."</div></div>";
				
	}
	
} 
 
 

// plugin administration area
 
add_action('admin_menu', 'wp_watermark_site_plugin_menu');

function wp_watermark_site_plugin_menu() {
	add_menu_page('WP Watermark Site settings', 'Watermark', 'administrator', 'wp-watermark-settings', 'wp_watermark_site_settings_page', 'dashicons-admin-appearance');
}


// load admin js
add_action('init','wp_watermark_site_js_init');
function wp_watermark_site_js_init() {
  wp_enqueue_script( 'wp_watermark_site_js', plugin_dir_url( __FILE__ ) . 'js/wp-watermark-site-1.4.1.js', array( 'jquery' ), '1.4.1' );
}


// enqueue color picker
add_action( 'admin_enqueue_scripts', 'wp_watermark_site_enqueue_color_picker' );
function wp_watermark_site_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp_color_picker', plugins_url('js/color-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}


// load admin styles
function load_wp_watermark_site_admin_register_head() {
	wp_register_style( 'wp_watermark_site_admin_style', plugin_dir_url( __FILE__ ) . 'css/adminstyle-1.1.1.css', false, '1.1.1' );
    wp_enqueue_style( 'wp_watermark_site_admin_style' );
	
}
add_action('admin_enqueue_scripts', 'load_wp_watermark_site_admin_register_head');


// admin page
function wp_watermark_site_settings_page() {
	
	//set default values if not options don't exist
	$watermarkimage=get_option('wp_watermark_site_image_url');
	$watermarkimage = $watermarkimage ?: 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Copyright.svg/600px-Copyright.svg.png';
	
	$watermarkopacity=get_option('wp_watermark_site_opacity');
	$watermarkopacity = $watermarkopacity ?: '0.5';
	
	$watermarktextfont=get_option('wp_watermark_site_text_font');
	$watermarktextfont = $watermarktextfont ?: 'roboto,arial,sans-serif';

	$watermarktextsize=get_option('wp_watermark_site_text_size');
	$watermarktextsize = $watermarktextsize ?: '100px';
	
	$wp_watermark_site_text_string=get_option('wp_watermark_site_text');
	$wp_watermark_site_text_string = $wp_watermark_site_text_string ?: 'WP<br><strong>Watermark</strong><br>Site';
	
	$wp_watermark_site_text_color=get_option('wp_watermark_site_color');
	$wp_watermark_site_text_color = $wp_watermark_site_text_color ?: '#000000';
	
	$watermarkzindex=get_option('wp_watermark_site_zindex');
	if (empty($watermarkzindex) && $watermarkzindex !== '0') {
		$watermarkzindex = $watermarkzindex ?: '9999';
	}

	
	
?>	
	<div class="wrap">
		<h2><?php esc_html_e( 'Watermark settings', 'wp-watermark-site' ); ?></h2>


		<form method="post" action="options.php">
			<?php settings_fields( 'wp_watermark_site_settings_group' ); ?>
			<?php do_settings_sections( 'wp_watermark_site_settings_group' ); ?>
			
			<input type="hidden" name="wp_watermark_site_watermark_on" id="wp_watermark_site_watermark_on" value="<?php echo esc_attr( get_option('wp_watermark_site_watermark_on') ); ?>">
			<input type="hidden" name="wp_watermark_site_text_on" id="wp_watermark_site_text_on" value="<?php echo esc_attr( get_option('wp_watermark_site_text_on') ); ?>">
			<input type="hidden" name="wp_watermark_site_image_on" id="wp_watermark_site_image_on" value="<?php echo esc_attr( get_option('wp_watermark_site_image_on') ); ?>">
			
		<div id="notsaved"><?php esc_html_e( 'Settings not saved!', 'wp-watermark-site' ); ?></div>
			
			<div id="watermark-switcher">
				<div id="watermark-switcher-text"><?php esc_html_e( 'Watermark is', 'wp-watermark-site' ); ?></div>
				<div id="watermark-switcher-button" onclick="checkradio();" />
						<table>
						<tr valign="top">
						<td><input type="radio" name="watermark-radio" id="watermark-radio-off" class="css-checkbox" onchange="wp_watermark_site_options_not_saved();" /><label for="watermark-radio-off" class="css-label watermark-radio"></label><div class="watermark-switcher-radio-text"><?php esc_html_e( 'off', 'wp-watermark-site' ); ?></div></td>
						<td><input type="radio" name="watermark-radio" id="watermark-radio-text" class="css-checkbox" onchange="wp_watermark_site_options_not_saved();" /><label for="watermark-radio-text" class="css-label watermark-radio chkgreen"></label><div class="watermark-switcher-radio-text"><?php esc_html_e( 'text', 'wp-watermark-site' ); ?></div></td>
						<td><input type="radio" name="watermark-radio" id="watermark-radio-image" class="css-checkbox" onchange="wp_watermark_site_options_not_saved();" /><label for="watermark-radio-image" class="css-label watermark-radio chkgreen"></label><div class="watermark-switcher-radio-text"><?php esc_html_e( 'image', 'wp-watermark-site' ); ?></div></td>
					</tr>
					</table>
				</div>
			</div>
			<table id="watermark-form" class="form-table">
			
				<tbody id="watermark-text-section">
					<tr valign="top"><th scope="row"><?php esc_html_e( 'Text to appear as the watermark', 'wp-watermark-site' ); ?></th></tr>
					<tr><td><?php esc_html_e( 'Allowed HTML tags: <strong></strong> <br> <em></em> <a href=""></a>', 'wp-watermark-site' ); ?></td></tr>
					<tr><td><input type="text" size="45" maxlength="100" name="wp_watermark_site_text" onchange="wp_watermark_site_options_not_saved();" value="<?php echo ( $wp_watermark_site_text_string ); ?>" /></td></tr>
					
					<tr><td><div style="line-height:1;font-family:<?php echo esc_attr( $watermarktextfont ); ?>; font-size:<?php echo esc_attr( $watermarktextsize ); ?>; color:<?php echo esc_attr( $wp_watermark_site_text_color ); ?>; opacity:<?php echo esc_attr( $watermarkopacity ); ?>" ><?php echo ( $wp_watermark_site_text_string ); ?></td></tr>

					<tr valign="top"><th scope="row"><?php esc_html_e( 'Font stack', 'wp-watermark-site' ); ?></th></tr>
					<tr><td><?php esc_html_e( 'For example: arial,helvetica,sans-serif. Default: roboto,arial,sans-serif', 'wp-watermark-site' ); ?></td></tr>
					<tr><td><input type="text" size="45" maxlength="100" name="wp_watermark_site_text_font" onchange="wp_watermark_site_options_not_saved();" value="<?php echo ( $watermarktextfont ); ?>" /></td></tr>
					
					<tr valign="top"><th scope="row"><?php esc_html_e( 'Font size', 'wp-watermark-site' ); ?></th></tr>
					<tr><td><?php esc_html_e( 'Include unit, for example 100px or 8em', 'wp-watermark-site' ); ?></td></tr>
					<tr><td><input type="text" size="4" maxlength="8" name="wp_watermark_site_text_size" onchange="wp_watermark_site_options_not_saved();" value="<?php echo ( $watermarktextsize ); ?>" /></td></tr>

					<tr valign="top"><th scope="row"><?php esc_html_e( 'Color', 'wp-watermark-site' ); ?></th></tr>
					<tr><td><input type="text" name="wp_watermark_site_color" class="wp-watermark-site-input-color" onchange="wp_watermark_site_options_not_saved();" data-default-color="#000000" value="<?php echo ( $wp_watermark_site_text_color ); ?>" /></td></tr>
				</tbody>
				
				
				<tbody id="watermark-image-section">
					<tr valign="top"><th scope="row"><?php esc_html_e( 'Watermark image', 'wp-watermark-site' ); ?></th></tr>
					<tr><td><?php esc_html_e( 'Upload an image or enter the image URL', 'wp-watermark-site' ); ?></td></tr>
					
					<tr><td><div><input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="<?php esc_html_e( 'Upload image', 'wp-watermark-site' ); ?>"><input type="text" name="wp_watermark_site_image_url" id="wp_watermark_site_image_url" onchange="wp_watermark_site_options_not_saved();" value="<?php echo ( $watermarkimage ); ?>" class="regular-text"></div></td></tr>
					
					<tr><td><img src="<?php echo esc_attr( $watermarkimage ); ?>" height="300" style="opacity:<?php echo ( $watermarkopacity ); ?>"></td></tr>
					
					<tr valign="top"><th scope="row"><?php esc_html_e( 'Image width', 'wp-watermark-site' ); ?></th></tr>
					<tr><td><?php esc_html_e( 'Include unit, for example 500px or 25%, or leave blank for original size', 'wp-watermark-site' ); ?></td></tr>
					<tr><td><input type="text" size="4" maxlength="8" name="wp_watermark_site_image_size" onchange="wp_watermark_site_options_not_saved();" value="<?php echo esc_attr( get_option('wp_watermark_site_image_size') ); ?>" /></td></tr>
				</tbody>
				

				<tr valign="top"><th scope="row"><?php esc_html_e( 'Position', 'wp-watermark-site' ); ?></th></tr>
				<tr>
				<td><table class="wp-watermark-site-position-table">
					<tr>
					<td style="width:33%;"><input type="radio" name="wp_watermark_site_position" onchange="wp_watermark_site_options_not_saved();" value="topleft" <?php checked('topleft',get_option( 'wp_watermark_site_position' ) ); ?> /><br /><?php esc_html_e( 'Top left', 'wp-watermark-site' ); ?></td>
					<td class="watermark-topcenter" style="width:34%;"><input type="radio" name="wp_watermark_site_position" onchange="wp_watermark_site_options_not_saved();" value="topcenter" <?php checked('topcenter',get_option( 'wp_watermark_site_position' ) ); ?> /><br /><?php esc_html_e( 'Top center', 'wp-watermark-site' ); ?></td>
					<td style="width:33%;"><input type="radio" name="wp_watermark_site_position" onchange="wp_watermark_site_options_not_saved();" value="topright" <?php checked('topright',get_option( 'wp_watermark_site_position' ) ); ?> /><br /><?php esc_html_e( 'Top right', 'wp-watermark-site' ); ?></td>
					</tr>
					<tr>
					<td><input type="radio" name="wp_watermark_site_position" onchange="wp_watermark_site_options_not_saved();" value="middleleft" <?php checked('middleleft',get_option( 'wp_watermark_site_position' ) ); ?> /><br /><?php esc_html_e( 'Middle left', 'wp-watermark-site' ); ?></td>
					<td class="watermark-topcenter"><input type="radio" name="wp_watermark_site_position" onchange="wp_watermark_site_options_not_saved();" value="middlecenter" <?php checked('middlecenter',get_option( 'wp_watermark_site_position' ) ); ?> /><br /><?php esc_html_e( 'Middle center', 'wp-watermark-site' ); ?></td>
					<td><input type="radio" name="wp_watermark_site_position" onchange="wp_watermark_site_options_not_saved();" value="middleright" <?php checked('middleright',get_option( 'wp_watermark_site_position' ) ); ?> /><br /><?php esc_html_e( 'Middle right', 'wp-watermark-site' ); ?></td>
					</tr>
					<tr>
					<td><input type="radio" name="wp_watermark_site_position" onchange="wp_watermark_site_options_not_saved();" value="bottomleft" <?php checked('bottomleft',get_option( 'wp_watermark_site_position' ) ); ?> /><br /><?php esc_html_e( 'Bottom left', 'wp-watermark-site' ); ?></td>
					<td class="watermark-topcenter"><input type="radio" name="wp_watermark_site_position" onchange="wp_watermark_site_options_not_saved();" value="bottomcenter" <?php checked('bottomcenter',get_option( 'wp_watermark_site_position' ) ); ?> /><br /><?php esc_html_e( 'Bottom center', 'wp-watermark-site' ); ?></td>
					<td><input type="radio" name="wp_watermark_site_position" onchange="wp_watermark_site_options_not_saved();" value="bottomright" <?php checked('bottomright',get_option( 'wp_watermark_site_position' ) ); ?> /><br /><?php esc_html_e( 'Bottom right', 'wp-watermark-site' ); ?></td>
					</tr>
					</table>
				</td></tr>
				
				<tr valign="top"><th scope="row"><?php esc_html_e( 'Z-index', 'wp-watermark-site' ); ?> (default: 9999)</th></tr>
				<tr><td><?php esc_html_e( 'Try -1 to place underneath all existing theme layers', 'wp-watermark-site' ); ?></td></tr>
				<tr><td><input type="text" size="4" name="wp_watermark_site_zindex" onchange="wp_watermark_site_options_not_saved();" value="<?php echo ( $watermarkzindex ); ?>" /></td></tr>

				<tr valign="top"><th scope="row"><?php esc_html_e( 'Opacity', 'wp-watermark-site' ); ?> (0 - 1)</th></tr>
				<tr><td><input type="text" size="4" name="wp_watermark_site_opacity" onchange="wp_watermark_site_options_not_saved();" value="<?php echo ( $watermarkopacity ); ?>" /></td></tr>
			</table>
			
			
			<?php submit_button(); ?>
			
			<?php if( isset($_GET['settings-updated']) ) { ?>
			<script>checkradio();</script>
			<div id="message" class="updated fade">
			<p><strong><?php esc_html_e('Settings saved.',  'wp-watermark-site' ) ?></strong></p>
			</div>
			<?php } ?>				

		</form>
	</div>
<?php
}


function wp_watermark_site_sanitize($option){
  $option = sanitize_text_field($option);
  return $option;
}

function wp_watermark_site_text_sanitize($option){
  $option = wp_kses( $option, array( 
    'a' => array(
		'href' => array()
    ),
    'br' => array(),
	'strong' => array(),
    'em' => array()
) );
  return $option;
}


add_action( 'admin_init', 'wp_watermark_site_settings' );

function wp_watermark_site_settings() {
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_watermark_on' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_text_on' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_image_on' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_image_size', 'wp_watermark_site_text_sanitize' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_text', 'wp_watermark_site_text_sanitize' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_text_size', 'wp_watermark_site_text_sanitize' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_text_font', 'wp_watermark_site_text_sanitize' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_color' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_position' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_zindex', 'wp_watermark_site_text_sanitize' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_opacity', 'wp_watermark_site_sanitize' );
	register_setting( 'wp_watermark_site_settings_group', 'wp_watermark_site_image_url', 'wp_watermark_site_sanitize' );
}